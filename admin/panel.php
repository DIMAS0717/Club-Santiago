<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

require __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/auth.php';

require_login();

$view = $_GET['view'] ?? 'dashboard';
$mensaje = '';

$admin_id = $_SESSION['admin_id'] ?? 0;

// Cargar datos del admin sin get_result (por compatibilidad)
$stmt = $conn->prepare("SELECT username, nombre, correo, foto, pais, estado, fecha_hora_local FROM admins WHERE id = ?");
$stmt->bind_param('i', $admin_id);
$stmt->execute();
$stmt->bind_result($username, $nombre, $correo, $foto, $pais, $estado, $fecha_hora_local);
if ($stmt->fetch()) {
  $admin = [
    'username' => $username,
    'nombre'   => $nombre,
    'correo'   => $correo,
    'foto'     => $foto,
    'pais'     => $pais,
    'estado'   => $estado,
    'fecha_hora_local' => $fecha_hora_local
  ];
} else {
  $admin = [
    'username' => 'admin',
    'nombre'   => '',
    'correo'   => '',
    'foto'     => '',
    'pais'     => '',
    'estado'   => '',
    'fecha_hora_local' => null
  ];
}
$stmt->close();

/* ========= MANEJO DE FORMULARIOS ========= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  /* Cambiar contraseña */
  if ($action === 'change_password') {
    $actual = $_POST['password_actual'] ?? '';
    $nueva1 = $_POST['password_nueva'] ?? '';
    $nueva2 = $_POST['password_nueva2'] ?? '';

    $stmt = $conn->prepare("SELECT password_hash FROM admins WHERE id = ?");
    $stmt->bind_param('i', $admin_id);
    $stmt->execute();
    $stmt->bind_result($hash_actual);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($actual, $hash_actual)) {
      $mensaje = 'La contraseña actual no es correcta.';
      $view = 'pass';
    } elseif ($nueva1 !== $nueva2) {
      $mensaje = 'Las contraseñas nuevas no coinciden.';
      $view = 'pass';
    } elseif (strlen($nueva1) < 8 || !preg_match('/[a-z]/', $nueva1) || !preg_match('/[A-Z]/', $nueva1) || !preg_match('/\d/', $nueva1)) {
      $mensaje = 'La nueva contraseña debe tener mínimo 8 caracteres, mayúsculas, minúsculas y número.';
      $view = 'pass';
    } else {
      $nuevo_hash = password_hash($nueva1, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("UPDATE admins SET password_hash = ? WHERE id = ?");
      $stmt->bind_param('si', $nuevo_hash, $admin_id);
      $stmt->execute();
      $stmt->close();
      $mensaje = 'Contraseña actualizada correctamente.';
      $view = 'pass';
    }
  }

  /* Editar perfil */
  if ($action === 'update_profile') {
    $nombreP = trim($_POST['nombre'] ?? '');
    $correoP = trim($_POST['correo'] ?? '');
    $paisP   = trim($_POST['pais'] ?? '');
    $estadoP = trim($_POST['estado'] ?? '');
    $fecha  = $_POST['fecha'] ?? '';
    $hora   = $_POST['hora'] ?? '';

    $fecha_hora = null;
    if ($fecha && $hora) {
      $fecha_hora = "$fecha $hora:00";
    }

    $foto_path = $admin['foto'];

    if (!empty($_FILES['foto']['name'])) {
      $uploadDir = __DIR__ . '/../uploads';
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
      }
      $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['foto']['name']);
      $destino = $uploadDir . '/' . $safeName;

      if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
        $foto_path = 'uploads/' . $safeName;
      }
    }

    if ($fecha_hora) {
      $stmt = $conn->prepare("UPDATE admins
        SET nombre=?, correo=?, pais=?, estado=?, fecha_hora_local=?, foto=?
        WHERE id=?");
      $stmt->bind_param('ssssssi', $nombreP, $correoP, $paisP, $estadoP, $fecha_hora, $foto_path, $admin_id);
    } else {
      $stmt = $conn->prepare("UPDATE admins
        SET nombre=?, correo=?, pais=?, estado=?, foto=?
        WHERE id=?");
      $stmt->bind_param('sssssi', $nombreP, $correoP, $paisP, $estadoP, $foto_path, $admin_id);
    }
    $stmt->execute();
    $stmt->close();
    $mensaje = 'Perfil actualizado.';
    $view = 'perfil';
  }

  /* Crear / editar propiedad (con foto principal, galería y categoría) */
  if ($action === 'save_property') {
    $id_prop = (int)($_POST['id'] ?? 0);
    $nombreProp  = trim($_POST['nombre'] ?? '');
    $capacidad = (int)($_POST['capacidad'] ?? 0);
    $recamaras = isset($_POST['recamaras']) ? (int)$_POST['recamaras'] : null;
    $banos = isset($_POST['banos']) ? (int)$_POST['banos'] : null;
    $estacionamiento = trim($_POST['estacionamiento'] ?? '');
    $desc_corta = trim($_POST['descripcion_corta'] ?? '');
    $desc_larga = trim($_POST['descripcion_larga'] ?? '');
    $ubicacion  = trim($_POST['ubicacion'] ?? '');
    $distancia  = trim($_POST['distancia_mar'] ?? '');
    $servicios  = trim($_POST['servicios'] ?? '');
    $indicaciones = trim($_POST['indicaciones'] ?? '');
    $enlace_drive = trim($_POST['enlace_drive'] ?? '');
    $datos_contacto = trim($_POST['datos_contacto'] ?? '');
    $estado_base = $_POST['estado_base'] ?? 'disponible';
    $categoria   = $_POST['categoria'] ?? 'renta'; // renta / venta / villa

    // Foto actual (si se está editando)
    $foto_principal = $_POST['foto_actual'] ?? '';

    // Carpeta para las fotos
    $baseDir = __DIR__ . '/../uploads/propiedades';
    if (!is_dir($baseDir)) {
      mkdir($baseDir, 0777, true);
    }

    // 1) FOTO PRINCIPAL
    if (!empty($_FILES['foto_principal']['name'])) {
      $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['foto_principal']['name']);
      $destino  = $baseDir . '/' . $safeName;

      if (move_uploaded_file($_FILES['foto_principal']['tmp_name'], $destino)) {
        $foto_principal = 'uploads/propiedades/' . $safeName;
      }
    }

       // 2) INSERT / UPDATE de la propiedad
if ($id_prop > 0) {
  // UPDATE con recámaras / baños / estacionamiento
  $sqlUpdate = "UPDATE properties
    SET nombre=?,
        capacidad=?,
        recamaras=?,
        banos=?,
        estacionamiento=?,
        descripcion_corta=?,
        descripcion_larga=?,
        ubicacion=?,
        distancia_mar=?,
        servicios=?,
        indicaciones=?,
        enlace_drive=?,
        datos_contacto=?,
        foto_principal=?,
        estado_base=?,
        categoria=?
    WHERE id=?";

  $stmt = $conn->prepare($sqlUpdate);
  if (!$stmt) {
    die('Error prepare UPDATE: ' . $conn->error);
  }

  $stmt->bind_param(
    'siiissssssssssssi',
    $nombreProp,        // s
    $capacidad,         // i
    $recamaras,         // i
    $banos,             // i
    $estacionamiento,   // s
    $desc_corta,        // s
    $desc_larga,        // s
    $ubicacion,         // s
    $distancia,         // s
    $servicios,         // s
    $indicaciones,      // s
    $enlace_drive,      // s
    $datos_contacto,    // s
    $foto_principal,    // s
    $estado_base,       // s
    $categoria,         // s
    $id_prop            // i
  );


      if (!$stmt->execute()) {
        die("Error execute UPDATE: " . $stmt->error);
      }

      $stmt->close();
      $mensaje = 'Propiedad actualizada.';
    } else {
  // INSERT con recámaras / baños / estacionamiento
  $sqlInsert = "INSERT INTO properties
    (nombre,
     capacidad,
     recamaras,
     banos,
     estacionamiento,
     descripcion_corta,
     descripcion_larga,
     ubicacion,
     distancia_mar,
     servicios,
     indicaciones,
     enlace_drive,
     datos_contacto,
     foto_principal,
     estado_base,
     categoria)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

  $stmt = $conn->prepare($sqlInsert);
  if (!$stmt) {
    die('Error prepare INSERT: ' . $conn->error);
  }

  $stmt->bind_param(
    'siiissssssssssss',
    $nombreProp,       // s
    $capacidad,        // i
    $recamaras,        // i
    $banos,            // i
    $estacionamiento,  // s
    $desc_corta,       // s
    $desc_larga,       // s
    $ubicacion,        // s
    $distancia,        // s
    $servicios,        // s
    $indicaciones,     // s
    $enlace_drive,     // s
    $datos_contacto,   // s
    $foto_principal,   // s
    $estado_base,      // s
    $categoria         // s
  );


      if (!$stmt->execute()) {
        die("Error execute INSERT: " . $stmt->error);
      }

      $id_prop = $stmt->insert_id;
      $stmt->close();
      $mensaje = 'Propiedad creada.';
    }


    // 3) GALERÍA (hasta 7 fotos por envío)
    if ($id_prop > 0 && !empty($_FILES['galeria']['name'][0])) {
      $total = count($_FILES['galeria']['name']);
      $ordenBase = 0;

      for ($i = 0; $i < $total && $i < 7; $i++) {
        if ($_FILES['galeria']['error'][$i] !== UPLOAD_ERR_OK) continue;

        $safeName = time() . '_' . $i . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['galeria']['name'][$i]);
        $destino  = $baseDir . '/' . $safeName;

        if (move_uploaded_file($_FILES['galeria']['tmp_name'][$i], $destino)) {
          $archivo = 'uploads/propiedades/' . $safeName;
          $orden   = $ordenBase + $i;

          $stmt = $conn->prepare("INSERT INTO property_photos (property_id, archivo, orden)
                                  VALUES (?,?,?)");
          $stmt->bind_param('isi', $id_prop, $archivo, $orden);
          $stmt->execute();
          $stmt->close();
        }
      }
    }

    $view = 'casas';
  }

  /* Borrar propiedad */
  if ($action === 'delete_property') {
    $id_prop_del = (int)($_POST['id'] ?? 0);
    if ($id_prop_del > 0) {
      $stmt = $conn->prepare("DELETE FROM properties WHERE id=?");
      $stmt->bind_param('i', $id_prop_del);
      $stmt->execute();
      $stmt->close();
      $mensaje = 'Propiedad eliminada.';
      $view = 'casas';
    }
  }

  /* Guardar rango en calendario */
  if ($action === 'save_calendar') {
    $prop_id = (int)($_POST['property_id'] ?? 0);
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin    = $_POST['fecha_fin'] ?? '';
    $estado_cal   = $_POST['estado'] ?? 'ocupada';

    if ($prop_id > 0 && $fecha_inicio && $fecha_fin) {
      $stmt = $conn->prepare("INSERT INTO property_calendar
        (property_id, fecha_inicio, fecha_fin, estado)
        VALUES (?,?,?,?)");
      $stmt->bind_param('isss', $prop_id, $fecha_inicio, $fecha_fin, $estado_cal);
      $stmt->execute();
      $stmt->close();
      $mensaje = 'Calendario actualizado.';
      $view = 'calendario';
    }
  }

  /* Borrar rango calendario */
  if ($action === 'delete_calendar') {
    $cal_id = (int)($_POST['id'] ?? 0);
    if ($cal_id > 0) {
      $stmt = $conn->prepare("DELETE FROM property_calendar WHERE id=?");
      $stmt->bind_param('i', $cal_id);
      $stmt->execute();
      $stmt->close();
      $mensaje = 'Rango eliminado.';
      $view = 'calendario';
    }
  }

  /* Borrar foto individual de la galería */
  if ($action === 'delete_photo') {
    $photo_id = (int)($_POST['id'] ?? 0);

    if ($photo_id > 0) {
      $stmt = $conn->prepare("SELECT archivo FROM property_photos WHERE id=?");
      $stmt->bind_param('i', $photo_id);
      $stmt->execute();
      $stmt->bind_result($archivo);
      $archivoLocal = null;
      if ($stmt->fetch()) {
        $archivoLocal = $archivo;
      }
      $stmt->close();

      if ($archivoLocal) {
        $ruta = __DIR__ . '/../' . $archivoLocal;
        if (is_file($ruta)) {
          @unlink($ruta);
        }
      }

      $stmt = $conn->prepare("DELETE FROM property_photos WHERE id=?");
      $stmt->bind_param('i', $photo_id);
      $stmt->execute();
      $stmt->close();

      $mensaje = 'Foto eliminada.';
      $view = 'casas';
    }
  }
}

/* Datos comunes para varias vistas */
$lista_propiedades = [];
$res_prop = $conn->query("SELECT id, nombre FROM properties ORDER BY nombre ASC");
if ($res_prop) {
  while ($row = $res_prop->fetch_assoc()) {
    $lista_propiedades[] = $row;
  }
}

/* Propiedad a editar (si aplica) */
$prop_editar = null;
if ($view === 'casas' && isset($_GET['edit'])) {
  $id_edit = (int)$_GET['edit'];
  $res = $conn->query("SELECT * FROM properties WHERE id = $id_edit");
  if ($res && $res->num_rows) {
    $prop_editar = $res->fetch_assoc();
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel admin - Club Santiago</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="admin-body">
<div class="admin-layout">
  <aside class="admin-sidebar">
    <div class="admin-profile">
      <div class="admin-avatar">
        <?php if (!empty($admin['foto'])): ?>
          <img src="../<?php echo htmlspecialchars($admin['foto']); ?>" alt="Foto admin">
        <?php else: ?>
          <span><?php echo strtoupper(substr($admin['username'], 0, 1)); ?></span>
        <?php endif; ?>
      </div>
      <div>
        <p class="admin-name"><?php echo htmlspecialchars($admin['nombre'] ?: $admin['username']); ?></p>
        <p class="admin-email"><?php echo htmlspecialchars($admin['correo']); ?></p>
      </div>
    </div>

    <nav class="admin-nav">
      <a href="panel.php?view=dashboard" class="<?php echo $view==='dashboard'?'active':''; ?>">Panel de control</a>
      <a href="panel.php?view=casas" class="<?php echo $view==='casas'?'active':''; ?>">Subir casas</a>
      <a href="panel.php?view=calendario" class="<?php echo $view==='calendario'?'active':''; ?>">Gestionar calendario</a>
      <a href="panel.php?view=perfil" class="<?php echo $view==='perfil'?'active':''; ?>">Editar perfil</a>
      <a href="panel.php?view=pass" class="<?php echo $view==='pass'?'active':''; ?>">Cambiar contraseña</a>
      <a href="logout.php" class="logout-link">Cerrar sesión</a>
    </nav>
  </aside>

  <main class="admin-main">
    <?php if ($mensaje): ?>
      <div class="admin-alert"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <?php if ($view === 'dashboard'): ?>
      <section>
        <h1>Bienvenido, <?php echo htmlspecialchars($admin['nombre'] ?: $admin['username']); ?></h1>
        <p>Desde este panel podrás subir casas en renta, gestionar el calendario de ocupación,
           actualizar tu perfil y cambiar la contraseña.</p>
      </section>

    <?php elseif ($view === 'perfil'): ?>
      <section>
        <h1>Editar perfil</h1>
        <form method="post" enctype="multipart/form-data" class="admin-form">
          <input type="hidden" name="action" value="update_profile">
          <label>Nombre
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($admin['nombre']); ?>">
          </label>
          <label>Correo
            <input type="email" name="correo" value="<?php echo htmlspecialchars($admin['correo']); ?>">
          </label>

          <div class="form-row">
            <label>País
              <input type="text" name="pais" value="<?php echo htmlspecialchars($admin['pais']); ?>">
            </label>
            <label>Estado
              <input type="text" name="estado" value="<?php echo htmlspecialchars($admin['estado']); ?>">
            </label>
          </div>

          <div class="form-row">
            <label>Fecha actual
              <input type="date" name="fecha">
            </label>
            <label>Hora actual
              <input type="time" name="hora">
            </label>
          </div>

          <label>Foto
            <input type="file" name="foto" accept="image/*">
          </label>

          <button type="submit" class="btn-primary">Guardar perfil</button>
        </form>
      </section>

    <?php elseif ($view === 'pass'): ?>
      <section>
        <h1>Cambiar contraseña</h1>
        <form method="post" class="admin-form" id="formPassword">
          <input type="hidden" name="action" value="change_password">
          <label>Contraseña actual
            <input type="password" name="password_actual" required>
          </label>
          <label>Nueva contraseña
            <input type="password" name="password_nueva" id="passwordNueva" required>
            <small class="hint">Mínimo 8 caracteres, mayúscula, minúscula y número.</small>
          </label>
          <label>Repetir nueva contraseña
            <input type="password" name="password_nueva2" required>
          </label>
          <p id="passwordStrength" class="password-strength"></p>
          <button type="submit" class="btn-primary">Actualizar contraseña</button>
        </form>
      </section>

    <?php elseif ($view === 'casas'): ?>
      <?php
      $fotos_existentes = [];
      if ($prop_editar) {
        $prop_id_fotos = (int)$prop_editar['id'];
        $resFotos = $conn->query("SELECT id, archivo FROM property_photos WHERE property_id=$prop_id_fotos ORDER BY orden, id");
        if ($resFotos) {
          while ($ph = $resFotos->fetch_assoc()) {
            $fotos_existentes[] = $ph;
          }
        }
      }
      ?>
      <section>
        <h1>Subir / editar casas en renta</h1>

        <form method="post" enctype="multipart/form-data" class="admin-form">
          <input type="hidden" name="action" value="save_property">
          <input type="hidden" name="id" value="<?php echo $prop_editar['id'] ?? 0; ?>">
          <input type="hidden" name="foto_actual" value="<?php echo htmlspecialchars($prop_editar['foto_principal'] ?? ''); ?>">

          <label>Nombre de la casa
            <input type="text" name="nombre"
                   value="<?php echo htmlspecialchars($prop_editar['nombre'] ?? ''); ?>" required>
          </label>

                    <div class="form-row">
            <label>Capacidad de personas
              <input type="number" name="capacidad" min="1"
                     value="<?php echo htmlspecialchars($prop_editar['capacidad'] ?? 8); ?>" required>
            </label>

            <label>Recámaras
              <input type="number" name="recamaras" min="0"
                     value="<?php echo htmlspecialchars($prop_editar['recamaras'] ?? ''); ?>">
            </label>

            <label>Baños
              <input type="number" name="banos" min="0" step="1"
                     value="<?php echo htmlspecialchars($prop_editar['banos'] ?? ''); ?>">
            </label>
          </div>


          <label>Descripción corta
            <input type="text" name="descripcion_corta"
                   value="<?php echo htmlspecialchars($prop_editar['descripcion_corta'] ?? ''); ?>" required>
          </label>

          <label>Descripción larga
            <textarea name="descripcion_larga" rows="4"><?php
              echo htmlspecialchars($prop_editar['descripcion_larga'] ?? '');
            ?></textarea>
          </label>

          <div class="form-row">
            <label>Ubicación
              <input type="text" name="ubicacion"
                     value="<?php echo htmlspecialchars($prop_editar['ubicacion'] ?? ''); ?>">
            </label>
            <label>Distancia al mar
              <input type="text" name="distancia_mar"
                     value="<?php echo htmlspecialchars($prop_editar['distancia_mar'] ?? ''); ?>">
            </label>
          </div>
                    <label>Estacionamiento (ej. "1 auto", "2 autos")
            <input type="text" name="estacionamiento"
                   value="<?php echo htmlspecialchars($prop_editar['estacionamiento'] ?? ''); ?>">
          </label>


          <label>Servicios (ej: Alberca privada, Wi-Fi, TV SKY...)
            <textarea name="servicios" rows="3"><?php
              echo htmlspecialchars($prop_editar['servicios'] ?? '');
            ?></textarea>
          </label>

          <label>Indicaciones (ej: reglas de casa, check-in/check-out)
            <textarea name="indicaciones" rows="3"><?php
              echo htmlspecialchars($prop_editar['indicaciones'] ?? '');
            ?></textarea>
          </label>

          <label>Enlace de Drive a las fotos
            <input type="url" name="enlace_drive"
                   value="<?php echo htmlspecialchars($prop_editar['enlace_drive'] ?? ''); ?>">
          </label>

          <label>Datos de contacto (teléfono, WhatsApp)
            <input type="text" name="datos_contacto"
                   value="<?php echo htmlspecialchars($prop_editar['datos_contacto'] ?? ''); ?>">
          </label>

          <label>Foto principal
            <input type="file" name="foto_principal" accept="image/*">
            <?php if (!empty($prop_editar['foto_principal'])): ?>
              <small>Actual:
                <a href="../<?php echo htmlspecialchars($prop_editar['foto_principal']); ?>" target="_blank">
                  Ver foto
                </a>
              </small>
            <?php endif; ?>
          </label>

          <label>Galería (máx. 7 fotos por subida)
            <input type="file" name="galeria[]" accept="image/*" multiple>
            <small>Puedes seleccionar varias fotos con Ctrl / Shift.</small>
          </label>

          <label>Estado base
            <?php
              $estado_base = $prop_editar['estado_base'] ?? 'disponible';
            ?>
            <select name="estado_base">
              <option value="disponible" <?php if($estado_base==='disponible') echo 'selected'; ?>>
                Disponible
              </option>
              <option value="no_disponible" <?php if($estado_base==='no_disponible') echo 'selected'; ?>>
                No disponible (mantenimiento u otra razón)
              </option>
            </select>
          </label>

          <label>Categoría
            <?php
              $cat = $prop_editar['categoria'] ?? 'renta';
            ?>
            <select name="categoria">
              <option value="renta" <?php if($cat==='renta') echo 'selected'; ?>>
                Propiedad en renta
              </option>
              <option value="venta" <?php if($cat==='venta') echo 'selected'; ?>>
                Propiedad en venta
              </option>
              <option value="villa" <?php if($cat==='villa') echo 'selected'; ?>>
                Villa
              </option>
            </select>
          </label>

          <button type="submit" class="btn-primary">
            <?php echo $prop_editar ? 'Guardar cambios' : 'Crear propiedad'; ?>
          </button>
        </form>

        <?php if ($prop_editar && $fotos_existentes): ?>
          <hr class="divider">
          <h2>Galería actual</h2>
          <div class="gallery-grid">
            <?php foreach ($fotos_existentes as $foto): ?>
              <div class="gallery-item">
                <img src="../<?php echo htmlspecialchars($foto['archivo']); ?>" alt="">
                <form method="post" class="inline-form" onsubmit="return confirm('¿Eliminar esta foto?');">
                  <input type="hidden" name="action" value="delete_photo">
                  <input type="hidden" name="id" value="<?php echo $foto['id']; ?>">
                  <button type="submit" class="small-link danger">Borrar</button>
                </form>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <hr class="divider">

        <h2>Listado de propiedades</h2>
        <table class="admin-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Capacidad</th>
              <th>Categoría</th>
              <th>Estado base</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $res = $conn->query("SELECT id, nombre, capacidad, estado_base, categoria FROM properties ORDER BY created_at DESC");

            if ($res && $res->num_rows):
              while ($p = $res->fetch_assoc()):
          ?>
            <tr>
              <td><?php echo $p['id']; ?></td>
              <td><?php echo htmlspecialchars($p['nombre']); ?></td>
              <td><?php echo (int)$p['capacidad']; ?></td>
              <td><?php echo htmlspecialchars($p['categoria']); ?></td>
              <td><?php echo htmlspecialchars($p['estado_base']); ?></td>
              <td>
                <a href="panel.php?view=casas&edit=<?php echo $p['id']; ?>" class="small-link">Editar</a>
                ·
                <a href="../propiedad.php?id=<?php echo $p['id']; ?>" target="_blank" class="small-link">
                  Ver página
                </a>
                <form method="post" class="inline-form" onsubmit="return confirm('¿Eliminar esta casa?');">
                  <input type="hidden" name="action" value="delete_property">
                  <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                  <button type="submit" class="small-link danger">Borrar</button>
                </form>
              </td>
            </tr>
          <?php
              endwhile;
            else:
          ?>
            <tr><td colspan="6">Aún no hay propiedades.</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </section>

    <?php elseif ($view === 'calendario'): ?>
      <section>
        <h1>Gestionar calendario de ocupación</h1>

        <form method="post" class="admin-form">
          <input type="hidden" name="action" value="save_calendar">
          <label>Casa
            <select name="property_id" required>
              <option value="">Selecciona una casa</option>
              <?php foreach ($lista_propiedades as $p): ?>
                <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['nombre']); ?></option>
              <?php endforeach; ?>
            </select>
          </label>
          <div class="form-row">
            <label>Fecha inicio
              <input type="date" name="fecha_inicio" required>
            </label>
            <label>Fecha fin
              <input type="date" name="fecha_fin" required>
            </label>
          </div>
          <label>Estado de la casa en ese periodo
            <select name="estado">
              <option value="ocupada">Ocupada (rentada)</option>
              <option value="no_disponible">No disponible</option>
            </select>
          </label>
          <button type="submit" class="btn-primary">Guardar rango</button>
        </form>

        <hr class="divider">

        <h2>Rangos registrados</h2>
        <table class="admin-table">
          <thead>
            <tr>
              <th>Casa</th>
              <th>Del</th>
              <th>Al</th>
              <th>Estado</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php
          $sql = "SELECT c.id, p.nombre, c.fecha_inicio, c.fecha_fin, c.estado
                  FROM property_calendar c
                  JOIN properties p ON p.id = c.property_id
                  ORDER BY c.fecha_inicio DESC";
          $res = $conn->query($sql);
          if ($res && $res->num_rows):
            while ($r = $res->fetch_assoc()):
          ?>
            <tr>
              <td><?php echo htmlspecialchars($r['nombre']); ?></td>
              <td><?php echo htmlspecialchars($r['fecha_inicio']); ?></td>
              <td><?php echo htmlspecialchars($r['fecha_fin']); ?></td>
              <td><?php echo htmlspecialchars($r['estado']); ?></td>
              <td>
                <form method="post" class="inline-form" onsubmit="return confirm('¿Eliminar este rango?');">
                  <input type="hidden" name="action" value="delete_calendar">
                  <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                  <button type="submit" class="small-link danger">Borrar</button>
                </form>
              </td>
            </tr>
          <?php
            endwhile;
          else:
          ?>
            <tr><td colspan="5">No hay rangos registrados.</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </section>
    <?php endif; ?>
  </main>
</div>

<script src="../assets/app.js"></script>
</body>
</html>

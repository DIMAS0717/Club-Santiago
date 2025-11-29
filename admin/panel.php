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


        // 3) GALERÍA (hasta 8 fotos por envío)
    if ($id_prop > 0 && !empty($_FILES['galeria']['name'][0])) {
      $total = count($_FILES['galeria']['name']);
      $ordenBase = 0;

      // ahora permite hasta 8 fotos en la galería
      for ($i = 0; $i < $total && $i < 8; $i++) {
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

/* ========= ÚLTIMOS MOVIMIENTOS PARA EL DASHBOARD ========= */
$movimientos = [];

$sqlMov = "
  (SELECT 
      'Propiedad' AS tipo,
      nombre      AS detalle,
      created_at  AS fecha
   FROM properties)

  UNION ALL

  (SELECT 
      'Calendario' AS tipo,
      CONCAT(p.nombre, ' (', c.estado, ')') AS detalle,
      c.fecha_inicio AS fecha
   FROM property_calendar c
   JOIN properties p ON p.id = c.property_id)

  ORDER BY fecha DESC
  LIMIT 8
";

$resMov = $conn->query($sqlMov);
if ($resMov) {
  while ($row = $resMov->fetch_assoc()) {
    $movimientos[] = $row;
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
<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel admin - Club Santiago</title>

    <!-- ICONOS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/panel-admin.css">

   
</head>
<body>
    <!-- ============ SIDEBAR ============ -->
    <div class="left-side">
        <h1>Centro de Administración</h1>

        <!-- Avatar -->
        <div class="profile-avatar">
            <?php if (!empty($admin['foto']) && file_exists('../' . $admin['foto'])): ?>
                <img src="../<?php echo htmlspecialchars($admin['foto']); ?>" alt="Foto de perfil">
            <?php else: ?>
                <div class="avatar-initial">
                    <?php 
                    $nombreMostrar = $admin['nombre'] ?: $admin['username'];
                    $inicial = strtoupper(substr($nombreMostrar, 0, 1));
                    echo $inicial;
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Nombre -->
        <h2 class="profile-name">
            <?php 
            $nombre_completo = $admin['nombre'] ?: $admin['username'];
            $nombre_palabras = explode(' ', $nombre_completo);
            $primeras_dos_palabras = array_slice($nombre_palabras, 0, 2);
            echo implode(' ', $primeras_dos_palabras); 
            ?>
        </h2>

        <!-- Rol -->
        <p class="profile-role">
            <?php echo ucfirst(htmlspecialchars($admin['rol'] ?? 'Administrador')); ?>
        </p>

        <!-- NAV LATERAL (ahora usa ?view=...) -->
        <div class="sidebar-nav">
            <ul>
                <li class="<?php echo $view === 'dashboard' ? 'active' : ''; ?>">
                    <a href="panel.php?view=dashboard">
                        <i class="fas fa-user"></i> Mi Panel
                    </a>
                </li>
                <li class="<?php echo $view === 'casas' ? 'active' : ''; ?>">
                    <a href="panel.php?view=casas">
                        <i class="fas fa-house-user"></i> Casas
                    </a>
                </li>
                <li class="<?php echo $view === 'calendario' ? 'active' : ''; ?>">
                    <a href="panel.php?view=calendario">
                        <i class="fas fa-calendar-alt"></i> Calendario
                    </a>
                </li>
                <li class="<?php echo $view === 'perfil' ? 'active' : ''; ?>">
                    <a href="panel.php?view=perfil">
                        <i class="fas fa-id-card"></i> Editar perfil
                    </a>
                </li>
                <li class="<?php echo $view === 'pass' ? 'active' : ''; ?>">
                    <a href="panel.php?view=pass">
                        <i class="fas fa-lock"></i> Cambiar contraseña
                    </a>
                </li>
                <li>
                    <a href="../index.php">
                        <i class="fas fa-home"></i> Volver al inicio
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                    </a>
                </li>
            </ul>
        </div>

        <!-- Logo abajo -->
        <div class="logo-container">
            <a href="../index.php">
                <img src="../assets/images/lagartija.png" alt="Logo" class="logo">
            </a>
        </div>
    </div>
    
    <!-- ============ CONTENIDO PRINCIPAL ============ -->
    <div class="right-side">
        <!-- Header superior -->
        <header>
            <a href="../index.php">
                <img src="../assets/images/logofoter.png" class="logo" alt="logo">
            </a>
            <div class="header-options">
                <a href="logout.php" class="logout-link" title="Cerrar sesión">
                    <img src="../assets/images/lagartija.png" alt="logout" class="logout-icon">
                </a>
            </div>
        </header>

        <!-- Rectángulo de bienvenida -->
        <div class="rectangle">
            <div class="rectangle-text">
                <h1>
                    ¡Bienvenido a tu panel, 
                    <?php 
                        $nombre_completo = $admin['nombre'] ?: $admin['username'];
                        $nombre_palabras = explode(' ', $nombre_completo);
                        $primera_palabra = array_slice($nombre_palabras, 0, 1);
                        echo implode(' ', $primera_palabra); 
                    ?>!
                </h1>
                <p>
                    Aquí puedes administrar las casas de Club Santiago, gestionar el calendario y actualizar tu perfil.
                </p>
            </div>
            <img src="../assets/images/icon_admin.png" alt="hand" class="hand-header">
        </div>

        <!-- Mensaje (opcional) -->
        <?php if (!empty($mensaje)): ?>
            <div class="alert success">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>


        <?php if ($view === 'dashboard'): ?>
            <!-- ===== DASHBOARD: INFO PERSONAL + FOTO ===== -->
            <div class="content-section" id="mi-perfil">
                <h2>Información Personal</h2>
                <div class="profile-info">
                    <div class="info-item">
                        <span class="info-label">Nombre Completo</span>
                        <span class="info-value">
                            <?php echo htmlspecialchars($admin['nombre'] ?: $admin['username']); ?>
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Correo Electrónico</span>
                        <span class="info-value">
                            <?php echo htmlspecialchars($admin['correo']); ?>
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Rol</span>
                        <span class="info-value">
                            <span class="role-badge admin">
                                <?php echo ucfirst(htmlspecialchars($admin['rol'] ?? 'Administrador')); ?>
                            </span>
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Fecha de Registro</span>
                        <span class="info-value">
                            <?php 
                            echo !empty($admin['fecha_registro'])
                                ? date('d/m/Y', strtotime($admin['fecha_registro']))
                                : '—';
                            ?>
                        </span>
                    </div>
                </div>
            </div>
            

            <div class="content-section">
                
                <h2>Foto de Perfil</h2>
                <div class="avatar-container">
                    <div class="avatar-preview">
                        <?php if (!empty($admin['foto']) && file_exists('../' . $admin['foto'])): ?>
                            <img src="../<?php echo htmlspecialchars($admin['foto']); ?>" alt="Foto de perfil">
                        <?php else: ?>
                            <div class="avatar-initial">
                                <?php 
                                $nombreMostrar = $admin['nombre'] ?: $admin['username'];
                                echo strtoupper(substr($nombreMostrar, 0, 1));
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    

                    <!-- Form sencillo para cambiar solo la foto (usa el mismo "action" que tu perfil) -->
                    <form action="" method="POST" enctype="multipart/form-data" class="avatar-form">
                        <input type="hidden" name="action" value="update_profile">

                        <div class="form-group file-input-wrapper">
                            <label for="avatar" class="file-input-label">
                                <i class="fas fa-camera"></i> Cambiar foto
                            </label>
                            <input type="file" id="avatar" name="foto" class="file-input" accept="image/*">
                            <div id="file-name-display">No se ha seleccionado ningún archivo</div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar foto
                        </button>
                    </form>
                </div>
            </div>

                <!-- ===== ÚLTIMOS MOVIMIENTOS ===== -->
    <div class="content-section">
        <h2>Últimos movimientos</h2>

        <?php if (!empty($movimientos)): ?>
            <div class="articles-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimientos as $mov): ?>
                            <tr>
                                <td>
                                    <?php 
                                    echo $mov['fecha']
                                        ? date('d/m/Y H:i', strtotime($mov['fecha']))
                                        : '—';
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($mov['tipo']); ?></td>
                                <td><?php echo htmlspecialchars($mov['detalle']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-items">
                <i class="fas fa-info-circle"></i>
                No hay movimientos recientes todavía.
            </p>
        <?php endif; ?>
    </div>
<?php elseif ($view === 'perfil'): ?>

            
            <!-- ===== EDITAR PERFIL ===== -->
            <div class="content-section">
                <h2>Editar perfil</h2>
                <form method="post" enctype="multipart/form-data" class="biografia-form">
                    <input type="hidden" name="action" value="update_profile">

                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre"
                               value="<?php echo htmlspecialchars($admin['nombre']); ?>"
                               style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Correo</label>
                        <input type="email" name="correo"
                               value="<?php echo htmlspecialchars($admin['correo']); ?>"
                               style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                    </div>

                    <div class="form-group" style="margin-top:15px;display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:15px;">
                        <div>
                            <label>País</label>
                            <input type="text" name="pais"
                                   value="<?php echo htmlspecialchars($admin['pais']); ?>"
                                   style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                        </div>
                        <div>
                            <label>Estado</label>
                            <input type="text" name="estado"
                                   value="<?php echo htmlspecialchars($admin['estado']); ?>"
                                   style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:15px;display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:15px;">
                        <div>
                            <label>Fecha actual</label>
                            <input type="date" name="fecha"
                                   style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                        </div>
                        <div>
                            <label>Hora actual</label>
                            <input type="time" name="hora"
                                   style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Foto</label>
                        <input type="file" name="foto" accept="image/*"
                               style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;background:#f8fafc;">
                    </div>

                    <button type="submit" class="btn btn-primary" style="margin-top:20px;">
                        <i class="fas fa-save"></i> Guardar perfil
                    </button>
                </form>
            </div>

        <?php elseif ($view === 'pass'): ?>
            <!-- ===== CAMBIAR CONTRASEÑA ===== -->
            <div class="content-section">
                <h2>Cambiar contraseña</h2>
                <form method="post" class="biografia-form" id="formPassword">
                    <input type="hidden" name="action" value="change_password">

                    <div class="form-group">
                        <label>Contraseña actual</label>
                        <input type="password" name="password_actual" required
                               style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Nueva contraseña</label>
                        <input type="password" name="password_nueva" id="passwordNueva" required
                               style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                        <small class="hint">Mínimo 8 caracteres, mayúscula, minúscula y número.</small>
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Repetir nueva contraseña</label>
                        <input type="password" name="password_nueva2" required
                               style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                    </div>

                    <p id="passwordStrength" class="password-strength"></p>

                    <button type="submit" class="btn btn-primary" style="margin-top:20px;">
                        <i class="fas fa-save"></i> Actualizar contraseña
                    </button>
                </form>
            </div>

        <?php elseif ($view === 'casas'): ?>
            <!-- ===== CASAS ===== -->
            <?php
            $fotos_existentes = [];
            if (!empty($prop_editar)) {
                $prop_id_fotos = (int)$prop_editar['id'];
                $resFotos = $conn->query("SELECT id, archivo FROM property_photos WHERE property_id=$prop_id_fotos ORDER BY orden, id");
                if ($resFotos) {
                    while ($ph = $resFotos->fetch_assoc()) {
                        $fotos_existentes[] = $ph;
                    }
                }
            }
            ?>

            <div class="content-section">
                <h2>Subir / editar casas en renta</h2>

                <form method="post" enctype="multipart/form-data" class="biografia-form">
                    <input type="hidden" name="action" value="save_property">
                    <input type="hidden" name="id" value="<?php echo $prop_editar['id'] ?? 0; ?>">
                    <input type="hidden" name="foto_actual" value="<?php echo htmlspecialchars($prop_editar['foto_principal'] ?? ''); ?>">

                    <div class="form-group">
                        <label>Nombre de la casa</label>
                        <input type="text" name="nombre"
                               value="<?php echo htmlspecialchars($prop_editar['nombre'] ?? ''); ?>"
                               required
                               style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                    </div>

                    <div class="form-group" style="margin-top:15px;display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:15px;">
                        <div>
                            <label>Capacidad de personas</label>
                            <input type="number" name="capacidad" min="1"
                                   value="<?php echo htmlspecialchars($prop_editar['capacidad'] ?? 8); ?>"
                                   required
                                   style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                        </div>
                        <div>
                            <label>Recámaras</label>
                            <input type="number" name="recamaras" min="0"
                                   value="<?php echo htmlspecialchars($prop_editar['recamaras'] ?? ''); ?>"
                                   style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                        </div>
                        <div>
                            <label>Baños</label>
                            <input type="number" name="banos" min="0" step="1"
                                   value="<?php echo htmlspecialchars($prop_editar['banos'] ?? ''); ?>"
                                   style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Descripción corta</label>
                        <input type="text" name="descripcion_corta"
                               value="<?php echo htmlspecialchars($prop_editar['descripcion_corta'] ?? ''); ?>"
                               required
                               style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Descripción larga</label>
                        <textarea name="descripcion_larga" rows="4"
                                  style="width:100%;padding:12px;border-radius:12px;border:1px solid #ddd;"><?php
                            echo htmlspecialchars($prop_editar['descripcion_larga'] ?? '');
                        ?></textarea>
                    </div>

                    <div class="form-group" style="margin-top:15px;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;">
                        <div>
                            <label>Ubicación</label>
                            <input type="text" name="ubicacion"
                                   value="<?php echo htmlspecialchars($prop_editar['ubicacion'] ?? ''); ?>"
                                   style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                        </div>
                        <div>
                            <label>Distancia al mar</label>
                            <input type="text" name="distancia_mar"
                                   value="<?php echo htmlspecialchars($prop_editar['distancia_mar'] ?? ''); ?>"
                                   style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Estacionamiento (ej. "1 auto", "2 autos")</label>
                        <input type="text" name="estacionamiento"
                               value="<?php echo htmlspecialchars($prop_editar['estacionamiento'] ?? ''); ?>"
                               style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Servicios (ej: Alberca privada, Wi-Fi, TV SKY...)</label>
                        <textarea name="servicios" rows="3"
                                  style="width:100%;padding:12px;border-radius:12px;border:1px solid #ddd;"><?php
                            echo htmlspecialchars($prop_editar['servicios'] ?? '');
                        ?></textarea>
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Indicaciones (ej: reglas de casa, check-in/check-out)</label>
                        <textarea name="indicaciones" rows="3"
                                  style="width:100%;padding:12px;border-radius:12px;border:1px solid #ddd;"><?php
                            echo htmlspecialchars($prop_editar['indicaciones'] ?? '');
                        ?></textarea>
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Enlace de Drive a las fotos</label>
                        <input type="url" name="enlace_drive"
                               value="<?php echo htmlspecialchars($prop_editar['enlace_drive'] ?? ''); ?>"
                               style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Datos de contacto (teléfono, WhatsApp)</label>
                        <input type="text" name="datos_contacto"
                               value="<?php echo htmlspecialchars($prop_editar['datos_contacto'] ?? ''); ?>"
                               style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Foto principal</label>
                        <input type="file" name="foto_principal" accept="image/*"
                               style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;background:#f8fafc;">
                        <?php if (!empty($prop_editar['foto_principal'])): ?>
                            <small>
                                Actual:
                                <a href="../<?php echo htmlspecialchars($prop_editar['foto_principal']); ?>" target="_blank">
                                    Ver foto
                                </a>
                            </small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Galería (máx. 7 fotos por subida)</label>
                        <input type="file" name="galeria[]" accept="image/*" multiple
                               style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;background:#f8fafc;">
                        <small>Puedes seleccionar varias fotos con Ctrl / Shift.</small>
                    </div>

                    <div class="form-group" style="margin-top:15px;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;">
                        <div>
                            <label>Estado base</label>
                            <?php $estado_base = $prop_editar['estado_base'] ?? 'disponible'; ?>
                            <select name="estado_base"
                                    style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                                <option value="disponible" <?php if($estado_base==='disponible') echo 'selected'; ?>>
                                    Disponible
                                </option>
                                <option value="no_disponible" <?php if($estado_base==='no_disponible') echo 'selected'; ?>>
                                    No disponible
                                </option>
                            </select>
                        </div>

                        <div>
                            <label>Categoría</label>
                            <?php $cat = $prop_editar['categoria'] ?? 'renta'; ?>
                            <select name="categoria"
                                    style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
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
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="margin-top:20px;">
                        <?php echo !empty($prop_editar) ? 'Guardar cambios' : 'Crear propiedad'; ?>
                    </button>
                </form>
            </div>

            <?php if (!empty($prop_editar) && $fotos_existentes): ?>
                <div class="content-section">
                    <h2>Galería actual</h2>
                    <div class="stats-container" style="grid-template-columns:repeat(auto-fill,minmax(180px,1fr));">
                        <?php foreach ($fotos_existentes as $foto): ?>
                            <div class="stat-item">
                                <img src="../<?php echo htmlspecialchars($foto['archivo']); ?>" alt=""
                                     style="width:100%;height:140px;object-fit:cover;border-radius:12px;margin-bottom:10px;">
                                <form method="post" class="inline-form" onsubmit="return confirm('¿Eliminar esta foto?');">
                                    <input type="hidden" name="action" value="delete_photo">
                                    <input type="hidden" name="id" value="<?php echo $foto['id']; ?>">
                                    <button type="submit" class="btn btn-secondary small-link danger">
                                        Borrar
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="content-section">
                <h2>Listado de propiedades</h2>
                <div class="articles-container">
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
                                        <form method="post" class="inline-form" style="display:inline;" onsubmit="return confirm('¿Eliminar esta casa?');">
                                            <input type="hidden" name="action" value="delete_property">
                                            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                            <button type="submit" class="small-link danger" style="border:none;background:none;">
                                                Borrar
                                            </button>
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
                </div>
            </div>

        <?php elseif ($view === 'calendario'): ?>
            <!-- ===== CALENDARIO ===== -->
            <div class="content-section">
                <h2>Gestionar calendario de ocupación</h2>
                <form method="post" class="biografia-form">
                    <input type="hidden" name="action" value="save_calendar">

                    <div class="form-group">
                        <label>Casa</label>
                        <select name="property_id" required
                                style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                            <option value="">Selecciona una casa</option>
                            <?php foreach ($lista_propiedades as $p): ?>
                                <option value="<?php echo $p['id']; ?>">
                                    <?php echo htmlspecialchars($p['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group" style="margin-top:15px;display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:15px;">
                        <div>
                            <label>Fecha inicio</label>
                            <input type="date" name="fecha_inicio" required
                                   style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                        </div>
                        <div>
                            <label>Fecha fin</label>
                            <input type="date" name="fecha_fin" required
                                   style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:15px;">
                        <label>Estado de la casa en ese periodo</label>
                        <select name="estado"
                                style="width:100%;padding:10px;border-radius:12px;border:1px solid #ddd;">
                            <option value="ocupada">Ocupada (rentada)</option>
                            <option value="no_disponible">No disponible</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" style="margin-top:20px;">
                        Guardar rango
                    </button>
                </form>
            </div>

            <div class="content-section">
                <h2>Rangos registrados</h2>
                <div class="articles-container">
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
                                        <form method="post" class="inline-form" style="display:inline;" onsubmit="return confirm('¿Eliminar este rango?');">
                                            <input type="hidden" name="action" value="delete_calendar">
                                            <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                                            <button type="submit" class="small-link danger" style="border:none;background:none;">
                                                Borrar
                                            </button>
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
                </div>
            </div>

        <?php endif; ?>

        <footer style="margin-top:30px;text-align:center;color:#e5e7eb;font-size:0.85rem;">
            &copy; <?php echo date('Y'); ?> Club Santiago. Panel de administración.
        </footer>
    </div>

    <!-- JS peque para mostrar nombre del archivo al cambiar avatar -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarInput = document.getElementById('avatar');
            const fileNameDisplay = document.getElementById('file-name-display');

            if (avatarInput && fileNameDisplay) {
                avatarInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        fileNameDisplay.textContent = this.files[0].name;
                    } else {
                        fileNameDisplay.textContent = 'No se ha seleccionado ningún archivo';
                    }
                });
            }
        });
    </script>
</body>
</html>

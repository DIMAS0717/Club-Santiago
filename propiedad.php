
<?php
require __DIR__ . '/includes/db.php';

function obtenerEstadoCasa($conn, $property_id, $estado_base) {
  $hoy = date('Y-m-d');
  $sql = "SELECT estado
          FROM property_calendar
          WHERE property_id = ?
            AND ? BETWEEN fecha_inicio AND fecha_fin
          ORDER BY fecha_fin DESC
          LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('is', $property_id, $hoy);
  $stmt->execute();
  $stmt->bind_result($estado);
  if ($stmt->fetch()) {
    $stmt->close();
    return $estado;
  }
  $stmt->close();
  return $estado_base ?: 'disponible';
}

/**
 * Divide un texto en ítems (para servicios / indicaciones)
 * Soporta saltos de línea y comas.
 */
function split_items($text) {
  $text = trim((string)$text);
  if ($text === '') return [];

  // Normalizar saltos de línea
  $text = str_replace(["\r\n", "\r"], "\n", $text);

  // Separar por líneas o comas
  $parts = preg_split('/[\n,]+/', $text);

  $out = [];
  foreach ($parts as $p) {
    // Quitar espacios y bullets tipo "- " o "• "
    $p = trim($p);
    $p = ltrim($p, "-• \t");
    if ($p !== '') $out[] = $p;
  }
  return $out;
}


/* ================== Cargar propiedad ================== */

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  http_response_code(404);
  echo 'Propiedad no encontrada';
  exit;
}

$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$prop = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$prop) {
  http_response_code(404);
  echo 'Propiedad no encontrada';
  exit;
}

$estado_actual = obtenerEstadoCasa($conn, $id, $prop['estado_base']);
$estado_label = $estado_actual === 'ocupada'
  ? 'Ocupada'
  : ($estado_actual === 'no_disponible' ? 'No disponible' : 'Disponible');

/* ================== Fotos ================== */

$fotos = [];

// foto principal primero
if (!empty($prop['foto_principal'])) {
  $fotos[] = [
    'archivo' => $prop['foto_principal'],
    'titulo'  => 'Foto principal de ' . $prop['nombre']
  ];
}

// galería desde tabla
$stmt = $conn->prepare("SELECT archivo, titulo FROM property_photos WHERE property_id=? ORDER BY orden, id");
$stmt->bind_param('i', $id);
$stmt->execute();
$resFotos = $stmt->get_result();
while ($row = $resFotos->fetch_assoc()) {
  $fotos[] = [
    'archivo' => $row['archivo'],
    'titulo'  => $row['titulo'] ?: $prop['nombre']
  ];
}
$stmt->close();

// Para el carrusel y la galería
$slider_fotos = $fotos;  // SIN LÍMITE

$galeria_fotos = array_slice($fotos, 0, 4);

// Ítems para servicios e indicaciones
$servicios_items    = split_items($prop['servicios'] ?? '');
$indicaciones_items = split_items($prop['indicaciones'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($prop['nombre']); ?> - Club Santiago</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

<main class="property-wrapper">

  <!-- ====== FILA 1: CARRUSEL + RESUMEN ====== -->
  <section class="property-hero">

    <!-- Carrusel izquierda -->
    <?php if ($slider_fotos): ?>
      <div class="property-slider-card" data-slider="property">
        <div class="slider-main">
          <div class="slider-window">
            <div class="slider-track" data-slider-track>
              <?php foreach ($slider_fotos as $foto): ?>
                <div class="slide" data-slide>
                  <img src="<?php echo htmlspecialchars($foto['archivo']); ?>"
                       alt="<?php echo htmlspecialchars($foto['titulo']); ?>">
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <?php if (count($slider_fotos) > 1): ?>
            <button type="button" class="slider-arrow" data-prev>‹</button>
            <button type="button" class="slider-arrow" data-next>›</button>
          <?php endif; ?>
        </div>

        <!-- Quitamos los circulitos (dots) del carrusel -->
        <?php /* antes aquí estaban los slider-dots, ahora eliminados */ ?>
      </div>
    <?php else: ?>
      <div class="property-slider-card">
        <div class="slide">
          <span style="padding:16px; color:var(--text-muted); font-size:13px;">
            Próximamente fotos de esta casa.
          </span>
        </div>
      </div>
    <?php endif; ?>

    <!-- Resumen derecha -->
        <!-- Resumen derecha -->
    <aside class="property-summary-card">
      <!-- badges de estado + capacidad uno al lado del otro -->
      <div class="property-status-row">
        <span class="status-badge status-<?php echo htmlspecialchars($estado_actual); ?>">
          <?php echo htmlspecialchars($estado_label); ?>
        </span>
        <span class="status-badge status-soft">
          Capacidad: <?php echo (int)$prop['capacidad']; ?> personas
        </span>
      </div>

      <h1 class="property-title"><?php echo htmlspecialchars($prop['nombre']); ?></h1>

      <?php if (!empty($prop['descripcion_corta'])): ?>
        <p class="property-short">
          <?php echo htmlspecialchars($prop['descripcion_corta']); ?>
        </p>
      <?php endif; ?>

      <!-- Botones centrados, uno debajo del otro -->
      <div class="btn-row">
  <a class="btn-primary">Ver disponibilidad</a>
  <a class="btn-primary-outline">Solicitar cotización</a>
</div>


      <?php
        // Estos campos son opcionales (puedes crearlos en la tabla properties)
        $recamaras       = $prop['recamaras']       ?? null;
        $banos           = $prop['banos']           ?? null;
        $estacionamiento = $prop['estacionamiento'] ?? null;
      ?>

      <?php if ($recamaras || $banos || $estacionamiento): ?>
        <div class="property-mini-stats">
          <?php if ($recamaras): ?>
            <div class="mini-stat">
              <span class="mini-label">Recámaras</span>
              <span class="mini-value"><?php echo (int)$recamaras; ?></span>
            </div>
          <?php endif; ?>

          <?php if ($banos): ?>
            <div class="mini-stat">
              <span class="mini-label">Baños</span>
              <span class="mini-value"><?php echo (int)$banos; ?></span>
            </div>
          <?php endif; ?>

          <?php if ($estacionamiento): ?>
            <div class="mini-stat">
              <span class="mini-label">Estacionamiento</span>
              <span class="mini-value">
                <?php echo htmlspecialchars($estacionamiento); ?>
              </span>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </aside>

  </section>

  <!-- ====== FILA 2: DESCRIPCIÓN / SERVICIOS / INDICACIONES ====== -->
  <section class="property-info-grid">

    <!-- Descripción general -->
    <section class="property-card property-desc-card">
      <h2 class="section-title">Descripción general</h2>
      <p class="desc-text">
        <?php
          if (!empty($prop['descripcion_larga'])) {
            echo nl2br(htmlspecialchars($prop['descripcion_larga']));
          } elseif (!empty($prop['descripcion_corta'])) {
            echo htmlspecialchars($prop['descripcion_corta']);
          } else {
            echo 'Casa en Club Santiago con excelente ubicación y todas las comodidades para tu estancia.';
          }
        ?>
      </p>
    </section>

    <!-- Servicios (columna derecha) -->
    <aside class="property-card property-services-card">
      <h2 class="section-title">Servicios</h2>

      <?php if ($servicios_items): ?>
        <div class="services-list">
          <?php foreach ($servicios_items as $item): ?>
            <button type="button" class="chip chip-service">
              <?php echo htmlspecialchars($item); ?>
            </button>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="muted-text" style="margin-top:6px;">
          Agrega los servicios en el panel de administración para mostrarlos aquí.
        </p>
      <?php endif; ?>
    </aside>

    <!-- Indicaciones y reglas (debajo de descripción) -->
    <section class="property-card property-rules-card">
      <h3 class="section-subtitle" style="color: var(--text-main); font-weight: 600;">
        Indicaciones y reglas
      </h3>

      <?php if ($indicaciones_items): ?>
        <ul class="rules-list">
          <?php foreach ($indicaciones_items as $item): ?>
            <li><?php echo htmlspecialchars($item); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p class="muted-text">
          Puedes añadir indicaciones y reglas desde el panel de administración (campo “Indicaciones”).
        </p>
      <?php endif; ?>
    </section>

  </section>

  <!-- ====== GALERÍA ====== -->
  <section class="property-card property-gallery-card">
    <h2 class="section-title">Galería</h2>
    <?php if ($galeria_fotos): ?>
      <div class="gallery-grid">
        <?php foreach ($galeria_fotos as $foto): ?>
          <figure class="gallery-item">
            <img src="<?php echo htmlspecialchars($foto['archivo']); ?>"
                 alt="<?php echo htmlspecialchars($foto['titulo']); ?>">
          </figure>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="muted-text" style="margin-top:8px;">
        Aún no hay fotos adicionales para esta casa.
      </p>
    <?php endif; ?>
  </section>

  <!-- ====== UBICACIÓN ====== -->
  <section id="ubicacion" class="property-card property-location-card">
    <h2 class="section-title">Ubicación</h2>
    <div class="location-rows">
      <?php if (!empty($prop['ubicacion'])): ?>
        <div class="location-row">
          <span class="location-label">Dirección</span>
          <span class="location-value"><?php echo htmlspecialchars($prop['ubicacion']); ?></span>
        </div>
      <?php endif; ?>
      <?php if (!empty($prop['distancia_mar'])): ?>
        <div class="location-row">
          <span class="location-label">Distancia al mar</span>
          <span class="location-value"><?php echo htmlspecialchars($prop['distancia_mar']); ?></span>
        </div>
      <?php endif; ?>
      <?php if (!empty($prop['enlace_drive'])): ?>
        <div class="location-row">
          <span class="location-label">Más imágenes / mapa</span>
          <span class="location-value">
            <a href="<?php echo htmlspecialchars($prop['enlace_drive']); ?>"
               target="_blank" class="small-link">
              Ver en Drive
            </a>
          </span>
        </div>
      <?php endif; ?>
      <?php if (!empty($prop['datos_contacto'])): ?>
        <div class="location-row">
          <span class="location-label">Contacto</span>
          <span class="location-value">
            <?php echo htmlspecialchars($prop['datos_contacto']); ?>
          </span>
        </div>
      <?php endif; ?>
    </div>
  </section>

</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="assets/app.js"></script>
</body>
</html>

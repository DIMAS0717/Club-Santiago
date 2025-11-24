<?php
require __DIR__ . '/includes/db.php';

// =========================
// 1) Consulta de propiedades
// =========================
$sql = "
  SELECT 
    p.id,
    p.nombre,
    p.capacidad,
    p.distancia_mar,
    p.descripcion_corta,
    p.foto_principal,
    p.categoria,
    p.estado_base,
    CASE
      -- PRIORIDAD 1: rango en calendario marcado como NO DISPONIBLE
      WHEN EXISTS (
        SELECT 1
        FROM property_calendar pc
        WHERE pc.property_id = p.id
          AND pc.estado = 'no_disponible'
          AND CURDATE() BETWEEN pc.fecha_inicio AND pc.fecha_fin
      ) THEN 'no_disponible'

      -- PRIORIDAD 2: rango en calendario marcado como OCUPADA
      WHEN EXISTS (
        SELECT 1
        FROM property_calendar pc
        WHERE pc.property_id = p.id
          AND pc.estado = 'ocupada'
          AND CURDATE() BETWEEN pc.fecha_inicio AND pc.fecha_fin
      ) THEN 'ocupada'

      -- PRIORIDAD 3: estado_base en la tabla properties
      WHEN p.estado_base = 'no_disponible' THEN 'no_disponible'

      -- PRIORIDAD 4: por defecto disponible
      ELSE 'disponible'
    END AS estado_actual
  FROM properties p
  WHERE p.categoria = 'renta'
  ORDER BY p.created_at DESC
";

$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Propiedades en renta - Casas Club Santiago</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="page-main">
  <section class="section">
    <h1>Propiedades en renta</h1>
    <p class="muted-text">Casas disponibles para renta en Club Santiago.</p>
  </section>

  <section class="section">
    <?php if ($res && $res->num_rows): ?>
      <div class="home-property-grid">
        <?php while ($p = $res->fetch_assoc()): ?>

          <?php
            // Normalizamos estado_base (minúsculas + sin espacios extra)
            $estado_base_raw = isset($p['estado_base'])
              ? strtolower(trim($p['estado_base']))
              : '';

            // Si en la base dice "no_disponible" o "no disponible", eso manda SIEMPRE
            if ($estado_base_raw === 'no_disponible' || $estado_base_raw === 'no disponible') {
              $estado = 'no_disponible';
            } else {
              // Si no, usamos lo calculado en el SQL (ocupada / disponible)
              $estado = $p['estado_actual'] ?? 'disponible';
            }

            // Elegimos etiqueta y clase según el estado final
            if ($estado === 'ocupada') {
              $estado_label = 'Ocupada';
              $estado_class = 'card-status-ocupada';
            } elseif ($estado === 'no_disponible') {
              $estado_label = 'No disponible';
              $estado_class = 'card-status-no-disponible';
            } else {
              $estado_label = 'Disponible';
              $estado_class = 'card-status-disponible';
            }
          ?>

         <article class="home-property-card">
  <div class="home-property-img-wrapper">
  <a href="propiedad.php?id=<?php echo $p['id']; ?>">

    <?php if (!empty($p['foto_principal'])): ?>
      <img
        src="<?php echo htmlspecialchars($p['foto_principal']); ?>"
        alt="<?php echo htmlspecialchars($p['nombre']); ?>"
        class="home-property-img"
      >
    <?php endif; ?>

    <!-- Estado: Disponible / No disponible / Ocupada -->
    <span class="card-status-chip <?php echo $estado_class; ?>">
      <?php echo htmlspecialchars($estado_label); ?>
    </span>

    <!-- 🔥 CÍRCULO DE CAPACIDAD -->
    <?php if (!empty($p['capacidad'])): ?>
      <div class="capacity-circle">
        <!-- AQUÍ PONES TU ICONO (imagen) -->
        <img src="assets/images/usuarios.png"
             alt="Capacidad"
             class="capacity-circle-icon">

        <!-- Número de personas -->
        <span class="capacity-circle-number">
          <?php echo (int)$p['capacidad']; ?>
        </span>
      </div>
    <?php endif; ?>

  </a>
</div>


  <div class="home-property-body">
    <h3 class="home-property-title">
      <?php echo htmlspecialchars($p['nombre']); ?>
    </h3>

    <?php if (!empty($p['descripcion_corta'])): ?>
      <p class="home-property-text">
        <?php echo htmlspecialchars($p['descripcion_corta']); ?>
      </p>
    <?php endif; ?>

    <!-- ya SIN las etiquetas de capacidad / distancia -->
    <a href="propiedad.php?id=<?php echo $p['id']; ?>" class="btn-primary home-property-btn">
      Ver detalles
    </a>
  </div>
</article>


        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="muted-text">Aún no hay propiedades registradas en renta.</p>
    <?php endif; ?>
  </section>
</main>

<?php include __DIR__ . '/includes/footer.php';?>

<script src="assets/app.js"></script>
</body>
</html>

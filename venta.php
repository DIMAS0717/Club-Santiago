<?php
require __DIR__ . '/includes/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Propiedades en venta - Casas Club Santiago</title>
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
    <h1>Propiedades en venta</h1>
    <p class="muted-text">Casas y propiedades disponibles para compra.</p>
  </section>

  <section class="section">
    <?php
    $sql = "SELECT id, nombre, descripcion_corta, foto_principal, categoria
            FROM properties
            WHERE categoria = 'venta'
            ORDER BY created_at DESC";
    $res = $conn->query($sql);
    ?>

    <?php if ($res && $res->num_rows): ?>
      <?php while ($p = $res->fetch_assoc()): ?>
        <article class="home-property-card">
          <?php if (!empty($p['foto_principal'])): ?>
            <a href="propiedad.php?id=<?php echo $p['id']; ?>">
              <img
                src="<?php echo htmlspecialchars($p['foto_principal']); ?>"
                alt="<?php echo htmlspecialchars($p['nombre']); ?>"
                class="home-property-img"
              >
            </a>
          <?php endif; ?>

          <div class="home-property-body">
            <h3><?php echo htmlspecialchars($p['nombre']); ?></h3>
            <?php if (!empty($p['descripcion_corta'])): ?>
              <p class="muted-text">
                <?php echo htmlspecialchars($p['descripcion_corta']); ?>
              </p>
            <?php endif; ?>

            <a href="propiedad.php?id=<?php echo $p['id']; ?>" class="btn-primary">
              Ver detalles
            </a>
          </div>
        </article>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="muted-text">Aún no hay propiedades registradas en venta.</p>
    <?php endif; ?>
  </section>
</main>

<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-logo">
      <img src="assets/logo-clubsantiago.png" alt="Logo Club Santiago">
      <span>Casas Club Santiago</span>
    </div>
    <small>© <?php echo date('Y'); ?> Casas Club Santiago - Manzanillo, Col.</small>
  </div>
</footer>

<script src="assets/app.js"></script>
</body>
</html>

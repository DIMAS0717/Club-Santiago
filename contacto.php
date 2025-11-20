<?php
require __DIR__ . '/includes/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Contáctanos - Casas Club Santiago</title>
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
    <h1>Contáctanos</h1>
    <p class="muted-text">
      En esta sección luego podemos poner un formulario, teléfonos, correo,
      WhatsApp y un mapa. Por ahora la dejamos sencilla para que no muestre nada raro.
    </p>
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

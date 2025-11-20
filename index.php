<?php
require __DIR__ . '/includes/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio - Casas Club Santiago</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; // si usas header separado, si no pega aquí el header de arriba ?>

<main class="page-main">
  <section class="section">
    <h1>Casas Club Santiago</h1>
    <p class="muted-text">
      Sitio oficial de rentas y ventas en Club Santiago, Manzanillo.
      Usa el menú superior para ver propiedades en renta, en venta, nuestras villas,
      alrededores y datos de contacto.
    </p>
  </section>

  <section class="section">
    <h2>Bienvenido</h2>
    <p class="muted-text">
      Aquí puedes mostrar un pequeño texto de presentación, una foto de Club Santiago,
      o un mensaje para tus clientes. Esta página no muestra listas de casas, eso se ve
      en las subpáginas de Renta, Venta y Villas.
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

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
  <link rel="stylesheet" href="assets/slider.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="page-main">
  <section class="section">
    <h1>Casas Club Santiago</h1>
    <p class="muted-text">
      Sitio oficial de rentas y ventas en Club Santiago, Manzanillo.
      Usa el menú superior para ver propiedades en renta, en venta, nuestras villas,
      alrededores y datos de contacto.
    </p>
  </section>

  <!--Carrusel de el inicio-->
  <section class="ve-hero">
  <div class="ve-hero-container">

    <!-- Slide 1 -->
    <div class="ve-slide active">
      <img src="assets/images/fondo_1.png" alt="">
      <div class="ve-overlay"></div>

      <div class="ve-text">
        <div class="ve-title-line"></div>
        <h2>Villas Eureka</h2>

        <p class="ve-sub">Tu descanso en Club Santiago</p>
        <p class="ve-desc">Villas familiares y casas vacacionales cerca de la playa</p>

        <a href="#" class="ve-btn">Ver propiedades →</a>
      </div>
    </div>

    <!-- AGREGAS TUS OTRAS 4 IMÁGENES AQUÍ -->
    <div class="ve-slide">
      <img src="assets/images/fondo_2.png" alt="">
      <div class="ve-overlay"></div>
      <div class="ve-text">
        <div class="ve-title-line"></div>
        <h2>Villas Eureka</h2>

        <p class="ve-sub">Tu descanso en Club Santiago</p>
        <p class="ve-desc">Villas familiares y casas vacacionales cerca de la playa</p>

        <a href="#" class="ve-btn">Ver propiedades →</a>
      </div>
    </div>

    <div class="ve-slide">
      <img src="assets/images/fondo_3.png" alt="">
      <div class="ve-overlay"></div>
      <div class="ve-text">
        <div class="ve-title-line"></div>
        <h2>Villas Eureka</h2>

        <p class="ve-sub">Tu descanso en Club Santiago</p>
        <p class="ve-desc">Villas familiares y casas vacacionales cerca de la playa</p>

        <a href="#" class="ve-btn">Ver propiedades →</a>
      </div>
    </div>

    <div class="ve-slide">
      <img src="assets/images/slide4.jpg" alt="">
      <div class="ve-overlay"></div>
      <div class="ve-text">
        <div class="ve-title-line"></div>
        <h2>Villas Eureka</h2>

        <p class="ve-sub">Tu descanso en Club Santiago</p>
        <p class="ve-desc">Villas familiares y casas vacacionales cerca de la playa</p>

        <a href="#" class="ve-btn">Ver propiedades →</a>
      </div>
    </div>

    <div class="ve-slide">
      <img src="assets/images/slide5.jpg" alt="">
      <div class="ve-overlay"></div>
      <div class="ve-text">
        <div class="ve-title-line"></div>
        <h2>Villas Eureka</h2>

        <p class="ve-sub">Tu descanso en Club Santiago</p>
        <p class="ve-desc">Villas familiares y casas vacacionales cerca de la playa</p>

        <a href="#" class="ve-btn">Ver propiedades →</a>
      </div>
    </div>

    <!-- Flechas -->
    <button class="ve-arrow ve-left">❮</button>
    <button class="ve-arrow ve-right">❯</button>

  </div>
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

<?php include __DIR__ . '/includes/footer.php';?>

<script src="assets/app.js"></script>
</body>
</html>

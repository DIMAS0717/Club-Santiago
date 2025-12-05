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


<?php
$slides = [
  "assets/images/fondo_1.JPG",
  "assets/images/fondo_2.JPG",
  "assets/images/fondo_3.JPG",
  "assets/images/fondo_4.JPG",
  "assets/images/fondo_5.JPG",
];
?>
<section class="ve-hero">
  <div class="ve-hero-container">

    <?php foreach ($slides as $i => $img): ?>
      <div class="ve-slide <?= $i === 0 ? 'active' : '' ?>">
        <img src="<?= $img ?>" alt="slide <?= $i+1 ?>">
        <div class="ve-overlay"></div>

        <div class="ve-text">
          <div class="ve-title-line"></div>
          <h2>Villas Eureka</h2>
          <p class="ve-sub">Tu descanso en Club Santiago</p>
          <p class="ve-desc">Villas familiares y casas vacacionales cerca de la playa</p>
          <a href="renta.php" class="ve-btn">Ver propiedades →</a>
        </div>
      </div>
    <?php endforeach; ?>

    <!-- Flechas -->
    <button class="ve-arrow ve-left">❮</button>
    <button class="ve-arrow ve-right">❯</button>

  </div>
</section>


</main>


<?php include __DIR__ . '/includes/footer.php';?>

<script src="assets/app.js"></script>
</body>
</html>

<?php
require __DIR__ . '/includes/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Alrededores - Casas Club Santiago</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/styles.css">
  <link rel="stylesheet" href="assets/alrededores.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="page-main alrededores-page">

  <!-- TÍTULO + INTRO -->
  <section class="section around-header">

  <div class="around-title-wrap">
    <img src="assets/images/iconoeureka.png" class="around-title-deco" alt="">
    <h1 class="around-title">Alrededores</h1>
    <img src="assets/images/iconoeureka.png" class="around-title-deco" alt="">
  </div>

  <span class="around-title-underline"></span>

  <p class="around-subtitle">
    Descubre los servicios, actividades y experiencias que puedes disfrutar
    cerca de nuestras casas en Club Santiago.
  </p>

</section>


  <!-- MAPA DE SERVICIOS -->
  <section class="section around-map-section">
    <div class="around-map-card">
      <div class="around-map-info">
        <h2 class="around-map-title">Mapa de Servicios y Puntos de Interés</h2>
        <ul class="around-map-list">
          <li>
            <span class="around-map-icon">🏥</span>
            <span>Hospital</span>
            <span class="around-map-time">5 min</span>
          </li>
          <li>
            <span class="around-map-icon">🛒</span>
            <span>Supermercado</span>
            <span class="around-map-time">4 min</span>
          </li>
          <li>
            <span class="around-map-icon">⛽</span>
            <span>Gasolinera</span>
            <span class="around-map-time">4 min</span>
          </li>
          <li>
            <span class="around-map-icon">🍽️</span>
            <span>Restaurantes</span>
            <span class="around-map-time">2–7 min</span>
          </li>
          <li>
            <span class="around-map-icon">🏖️</span>
            <span>Playas</span>
            <span class="around-map-time">2 min</span>
          </li>
        </ul>
      </div>

      <div class="around-map-image">
  <img id="openMap" src="assets/images/mapa.png" alt="Mapa de servicios cercanos">
</div>

<!-- MODAL DEL MAPA AMPLIADO -->
<div id="mapModal" class="map-modal">
  <span class="map-close">&times;</span>
  <img class="map-modal-content" id="mapModalImg">
</div>

  </section>

  <!-- PÍLDORAS DE SERVICIOS -->
  <section class="section around-chips-section">
    <h2 class="around-section-title">Servicios cercanos</h2>
    <div class="around-chips-row">
      <button class="around-chip">🏥 Hospital</button>
      <button class="around-chip">🛒 Supermercado</button>
      <button class="around-chip">⛽ Gasolinera</button>
      <button class="around-chip">🍽️ Restaurantes</button>
      <button class="around-chip">🏖️ Playas</button>
    </div>
  </section>

  <!--Deportes -->
  <section class="section around-activities-section">
  <h2 class="around-section-title">Deportes</h2>

  <div class="around-activities-grid">

    <!-- Senderismo -->
    <article class="around-activity-card around-activity-hiking">
      <div class="around-activity-badge badge-green">Naturaleza</div>
      <div class="around-activity-overlay">
        <h3>Senderismo</h3>
        <p>Rutas para disfrutar de la naturaleza y miradores espectaculares.</p>
        <a href="#" class="around-btn">Ver más →</a>
      </div>
    </article>

    <!-- Golf -->
    <article class="around-activity-card around-activity-golf">
      <div class="around-activity-badge badge-gray">Deporte</div>
      <div class="around-activity-overlay">
        <h3>Golf</h3>
        <p>Campo de golf cercano ideal para practicar o disfrutar con amigos.</p>
        <a href="#" class="around-btn">Ver más →</a>
      </div>
    </article>

    <!-- Ciclismo (NUEVO) -->
    <article class="around-activity-card around-activity-cycling">
      <div class="around-activity-badge badge-green">Aventura</div>
      <div class="around-activity-overlay">
        <h3>Ciclismo</h3>
        <p>Rutas seguras para recorrer en bicicleta y disfrutar el paisaje.</p>
        <a href="#" class="around-btn">Ver más →</a>
      </div>
    </article>

  </div>
</section>
<!--Experiencias Recomendadas -->
<section class="section around-experiences-section">
  <h2 class="around-section-title">Experiencias recomendadas</h2>

  <div class="around-experiences-grid">

    <!-- Banana -->
    <article class="around-experience-card">
      <div class="around-experience-image">
        <img src="assets/images/banana-playa.jpg" alt="Banana en la playa">
      </div>
      <div class="around-experience-body">
        <h3>Banana en la playa</h3>
        <p>Actividad divertida para grupos y familias con vista al mar.</p>
      </div>
    </article>

    <!-- Atardecer -->
    <article class="around-experience-card">
      <div class="around-experience-image">
        <img src="assets/images/atardecer-club-santiago.jpg" alt="Atardecer">
      </div>
      <div class="around-experience-body">
        <h3>Mejor punto para ver el atardecer</h3>
        <p>Fotografías increíbles y momentos únicos en la bahía.</p>
      </div>
    </article>

    <!-- Comida típica -->
    <article class="around-experience-card">
      <div class="around-experience-image">
        <img src="assets/images/comida.png" alt="Comidas típicas">
      </div>
      <div class="around-experience-body">
        <h3>Comidas típicas enramadas locales</h3>
        <p>Platillos tradicionales y mariscos frescos frente al mar.</p>
      </div>
    </article>

  </div>
</section>
<!--RESTTAURANTES-->
<section class="section around-experiences-section">
  <h2 class="around-section-title">Restaurantes</h2>

  <div class="around-experiences-grid">

    <!-- Oasis -->
    <article class="around-experience-card">
      <div class="around-experience-image">
        <img src="assets/images/oasis.jpg" alt="Restaurante Oasis">
      </div>
      <div class="around-experience-body">
        <h3>Restaurante OASIS</h3>
        <p>Ambiente agradable y comida fresca con vista al mar.</p>
      </div>
    </article>

    <!-- Delfos -->
    <article class="around-experience-card">
      <div class="around-experience-image">
        <img src="assets/images/delfos.jpg" alt="Restaurante Delfos">
      </div>
      <div class="around-experience-body">
        <h3>Restaurante Delfos</h3>
        <p>Especialidades del mar, pescados y mariscos de calidad.</p>
      </div>
    </article>

    <!-- Eureka -->
    <article class="around-experience-card">
      <div class="around-experience-image">
        <img src="assets/images/eureka-tienda.jpg" alt="Tienda Eureka">
      </div>
      <div class="around-experience-body">
        <h3>Tienda Eureka</h3>
        <p>Tienda local con artesanías y productos típicos de la región.</p>
      </div>
    </article>

  </div>
</section>

<section class="gallery-section">
  <div class="gallery-header">
    <h2>Galería de Club Santiago</h2>
    <p>Un vistazo a lo que te espera en este paraíso frente al mar</p>
  </div>

  <div class="gallery-grid">
    <!-- Imagen grande -->
    <div class="gallery-item large" style="background-image:url('assets/images/ciclismo.jpg')">
      <span>Playa La Boquita</span>
    </div>

    <!-- Imagen mediana -->
    <div class="gallery-item medium" style="background-image:url('assets/images/golf.jpg')">
      <span>Campo de Golf</span>
    </div>

    <!-- Imagen mediana -->
    <div class="gallery-item medium" style="background-image:url('assets/images/playa.jpg')">
      <span>Atardeceres Mágicos</span>
    </div>

    <!-- Imagen horizontal -->
    <div class="gallery-item wide" style="background-image:url('assets/images/senderismo.png')">
      <span>Marina</span>
    </div>
  </div>

  <div class="gallery-cta">
    <a href="#" class="btn-gallery">Ver galería completa</a>
  </div>
</section>


</main>


<?php include __DIR__ . '/includes/footer.php';?>

<script src="assets/app.js"></script>
<script>
  const modal = document.getElementById("mapModal");
  const modalImg = document.getElementById("mapModalImg");
  const img = document.getElementById("openMap");
  const closeBtn = document.querySelector(".map-close");

  img.onclick = function() {
    modal.style.display = "block";
    modalImg.src = this.src;
  }

  closeBtn.onclick = function() {
    modal.style.display = "none";
  }

  modal.onclick = function(e) {
    if (e.target === modal) {
      modal.style.display = "none";
    }
  }
</script>

</body>
</html>

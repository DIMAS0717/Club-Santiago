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
    <h1 class="around-title">Alrededores</h1>
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

  <!-- ACTIVIDADES DESTACADAS -->
  <section class="section around-activities-section">
    <h2 class="around-section-title">Actividades destacadas</h2>

    <div class="around-activities-grid">
      <!-- Senderismo -->
      <article class="around-activity-card around-activity-hiking">
        <div class="around-activity-badge badge-green">Naturaleza</div>
        <div class="around-activity-overlay">
          <h3>Senderismo</h3>
          <p>
            Rutas para disfrutar de la naturaleza, miradores y vistas
            espectaculares de la bahía.
          </p>
          <a href="#" class="around-btn">Ver más →</a>
        </div>
      </article>

      <!-- Playas -->
      <article class="around-activity-card around-activity-beach">
        <div class="around-activity-badge badge-blue">Relajación</div>
        <div class="around-activity-overlay">
          <h3>Playas</h3>
          <p>
            Playas tranquilas para descansar, nadar o disfrutar del atardecer
            a pocos minutos de tu casa.
          </p>
          <a href="#" class="around-btn">Ver más →</a>
        </div>
      </article>

      <!-- Golf -->
      <article class="around-activity-card around-activity-golf">
        <div class="around-activity-badge badge-gray">Deporte</div>
        <div class="around-activity-overlay">
          <h3>Golf</h3>
          <p>
            Campo de golf muy cercano, ideal para practicar o disfrutar de una
            ronda con amigos.
          </p>
          <a href="#" class="around-btn">Ver más →</a>
        </div>
      </article>
    </div>
  </section>

  <!-- EXPERIENCIAS RECOMENDADAS -->
  <section class="section around-experiences-section">
    <h2 class="around-section-title">Experiencias recomendadas</h2>

    <div class="around-experiences-grid">
      <article class="around-experience-card">
        <div class="around-experience-image">
          <img src="assets/images/comida.png" alt="Comidas típicas en ramadas">
        </div>
        <div class="around-experience-body">
          <h3>Comidas típicas en ramadas locales</h3>
          <p>
            Disfruta mariscos frescos y platillos típicos en ramadas frente al mar.
          </p>
        </div>
      </article>

      <article class="around-experience-card">
        <div class="around-experience-image">
          <img src="assets/images/atardecer-club-santiago.jpg" alt="Atardecer">
        </div>
        <div class="around-experience-body">
          <h3>Mejor punto para ver el atardecer</h3>
          <p>
            Lugares ideales para fotos y atardeceres impresionantes en Club Santiago.
          </p>
        </div>
      </article>

      <article class="around-experience-card">
        <div class="around-experience-image">
          <img src="assets/images/delfines-temporada.jpg" alt="Delfines en temporada">
        </div>
        <div class="around-experience-body">
          <h3>Avistamiento de delfines en temporada</h3>
          <p>
            En ciertas épocas del año es posible ver delfines desde la costa o en tours.
          </p>
        </div>
      </article>
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

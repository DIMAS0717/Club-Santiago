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
</head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<main class="page-main alrededores-page">

  <section class="section around-header" style="position: relative; overflow: hidden; padding: 100px 20px; text-align: center; min-height: 400px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
    
    <img src="assets/images/TU_IMAGEN_AQUI.jpg" alt="Fondo" 
         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1;">

    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 2;"></div>

    <div class="around-title-wrap" style="position: relative; z-index: 3; display: flex; align-items: center; justify-content: center; gap: 15px;">
      <img src="assets/images/iconoeureka.png" class="around-title-deco" alt="" style="width: 40px;">
      <h1 class="around-title" style="color: white; margin: 0; font-size: 3rem;">Alrededores</h1>
      <img src="assets/images/iconoeureka.png" class="around-title-deco" alt="" style="width: 40px;">
    </div>

    <span class="around-title-underline" style="position: relative; z-index: 3; background-color: white; height: 3px; width: 100px; display: block; margin: 20px auto;"></span>

    <p class="around-subtitle" style="position: relative; z-index: 3; color: white; max-width: 700px; font-size: 1.2rem;">
      Descubre los servicios, actividades y experiencias que puedes disfrutar cerca de nuestras casas en Club Santiago.
    </p>
  </section>

  <section class="section around-map-section" style="background-color: white; padding: 60px 20px;">
    <div class="around-map-card">
      <div class="around-map-info">
        <h1 class="around-map-title">
          Mapa de Servicios<br>
          <span>Puntos de Interés Cercanos</span>
        </h1>
        <div class="around-map-divider"></div>

        <ul class="around-map-list">
          <li>
            <svg class="around-map-icon" viewBox="0 0 24 24" style="width:24px; color:#f44336;"><path fill="currentColor" d="M10 2h4v6h6v4h-6v6h-4v-6H4V8h6z"/></svg>
            <span>Hospital</span>
            <span class="around-map-time">5 min</span>
          </li>
          <li>
            <svg class="around-map-icon" viewBox="0 0 24 24" style="width:24px;"><path fill="currentColor" d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM7.2 14.3h9.4c.75 0 1.4-.4 1.7-1l3.6-6.5L20.4 4H5.2L4.3 2H1v2h2l3.6 7.6-1.4 2.4C4.5 15.4 5.5 17 7 17h12v-2H7.4c-.15 0-.25-.1-.25-.25z"/></svg>
            <span>Supermercado</span>
            <span class="around-map-time">4 min</span>
          </li>
          </ul>
      </div>

      <div class="around-map-image">
        <img id="openMap" src="assets/images/mapa.png" alt="Mapa">
      </div>
    </div>
  </section>

</main>

<div id="mapModal" class="map-modal">
  <span class="map-close">&times;</span>
  <img class="map-modal-content" id="mapModalImg">
</div>

</section>

  <!--Deportes -->
  <div class="section-header">
    <span>ACTIVIDADES AL AIRE LIBRE</span>
    <h2 class="around-section-title">Deportes</h2>
  </div>

  <div class="around-activities-grid"> 

    <!-- Senderismo -->
    <article class="around-activity-card around-activity-hiking">
      <div class="around-activity-badge badge-green">Deportes</div>
      <div class="around-activity-overlay">
        <h3>Senderismo</h3>
        <p>Rutas para disfrutar de la naturaleza y miradores espectaculares.</p>
        <a href="#" class="around-btn">Ver más →</a>
      </div>
    </article>

    <!-- Golf -->
    <article class="around-activity-card around-activity-golf">
      <div class="around-activity-badge badge-green">Deporte</div>
      <div class="around-activity-overlay">
        <h3>Golf</h3>
        <p>Campo de golf cercano ideal para practicar o disfrutar con amigos.</p>
        <a href="#" class="around-btn">Ver más →</a>
      </div>
    </article>

    <!-- Ciclismo (NUEVO) -->
    <article class="around-activity-card around-activity-cycling">
      <div class="around-activity-badge badge-green">Deportes</div>
      <div class="around-activity-overlay">
        <h3>Ciclismo</h3>
        <p>Rutas seguras para recorrer en bicicleta y disfrutar el paisaje.</p>
        <a href="#" class="around-btn">Ver más →</a>
      </div>
    </article>

  </div>
</section>
<!--Experiencias Recomendadas -->
<section class="section around-activities-section">
  <div class="section-header">
    <h2 class="around-section-title">Experiencias recomendadas</h2>
  </div>

  <div class="around-activities-grid"> 
    <article class="around-activity-card experience-banana">
      <div class="around-activity-badge">Diversión</div>
      <div class="around-activity-overlay">
        <h3>Playas</h3>
        <p>Actividad divertida para grupos y familias con vista al mar.</p>
        <a href="#" class="around-btn">Ver más →</a>
      </div>
    </article>

    <article class="around-activity-card experience-sunset">
      <div class="around-activity-badge">Relax</div>
      <div class="around-activity-overlay">
        <h3>Ver el atardecer</h3>
        <p>Fotografías increíbles y momentos únicos en la bahía.</p>
        <a href="#" class="around-btn">Ver más →</a>
      </div>
    </article>

    <article class="around-activity-card experience-food">
      <div class="around-activity-badge">Sabor</div>
      <div class="around-activity-overlay">
        <h3>Comidas típicas</h3>
        <p>Platillos tradicionales y mariscos frescos frente al mar.</p>
        <a href="#" class="around-btn">Ver más →</a>
      </div>
    </article>
  </div>
</section>

<section class="section around-activities-section">
  <div class="section-header">
    <h2 class="around-section-title">Restaurantes</h2>
  </div>

  <div class="around-activities-grid"> 
    <article class="around-activity-card restaurant-oasis">
      <div class="around-activity-badge">Gastronomía</div>
      <div class="around-activity-overlay">
        <h3>Restaurante OASIS</h3>
        <p>Ambiente agradable y comida fresca con vista al mar.</p>
        <a href="#" class="around-btn">Ver más →</a>
      </div>
    </article>

    <article class="around-activity-card restaurant-delfos">
      <div class="around-activity-badge">Mariscos</div>
      <div class="around-activity-overlay">
        <h3>Restaurante Delfos</h3>
        <p>Especialidades del mar, pescados y mariscos de calidad.</p>
        <a href="#" class="around-btn">Ver más →</a>
      </div>
    </article>

    <article class="around-activity-card restaurant-eureka">
      <div class="around-activity-badge">Local</div>
      <div class="around-activity-overlay">
        <h3>Tienda Eureka</h3>
        <p>Tienda local con artesanías y productos típicos de la región.</p>
        <a href="#" class="around-btn">Ver más →</a>
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

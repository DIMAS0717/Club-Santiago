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
  <link rel="stylesheet" href="assets/contact.css">

  <!-- Fuente e iconos (para los círculos de la izquierda) -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

<main class="page-main">

  <section class="cs-contact-section">
    <h2>Contáctanos</h2>

    <div class="cs-contact-box">
      <!-- Panel izquierdo -->
      <div class="cs-left-panel">
        <div class="cs-info-block">
          <div class="cs-icon"><i class="fas fa-envelope"></i></div>
          <div>
            <p class="cs-label">Nuestro Email</p>
            <p class="cs-detail">goyorealestate@gmail.com</p>
          </div>
        </div>

        <div class="cs-info-block">
          <div class="cs-icon"><i class="fas fa-phone"></i></div>
          <div>
            <p class="cs-label">Teléfonos</p>
            <p class="cs-detail">
              (314) 355 0525<br>
              (314) 355 0026
            </p>
          </div>
        </div>

        <div class="cs-info-block">
          <div class="cs-icon"><i class="fas fa-map-marker-alt"></i></div>
          <div>
            <p class="cs-label">Ubicación</p>
            <p class="cs-detail">
              Calle Deltin D-05, Fracc. Club Santiago,<br>
              Manzanillo, Colima, MX. C.P. 28868
            </p>
          </div>
        </div>

        <div class="cs-socials">
          <p class="cs-label">Síguenos en Redes Sociales</p>
          <div class="cs-icons">
            <a class="cs-social" href="https://www.facebook.com/villaseurekamanzanillo/" target="_blank">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a class="cs-social" href="#" target="_blank">
              <i class="fab fa-instagram"></i>
            </a>
            <a class="cs-social" href="#" target="_blank">
              <i class="fab fa-whatsapp"></i>
            </a>
            <a class="cs-social" href="https://www.tiktok.com/@villas.eureka?_r=1&_t=ZS-91eOOj9KDQu" target="_blank">
      <i class="fab fa-tiktok social"></i>
    </a>
          </div>
        </div>
      </div>

      <!-- Panel derecho (formulario) -->
      <form class="cs-right-panel" method="post" action="#">
        <h3>Envíanos un Mensaje</h3>

        <div class="cs-form-row">
          <input
            type="text"
            name="nombre"
            placeholder="Nombre"
            class="cs-input"
            required
          />
          <input
            type="text"
            name="apellido"
            placeholder="Apellido"
            class="cs-input"
            required
          />
        </div>

        <input
          type="email"
          name="email"
          placeholder="Correo electrónico"
          class="cs-input"
          required
        />

        <textarea
          name="mensaje"
          placeholder="Mensaje / Fechas / Propiedad de interés"
          class="cs-input"
          required
        ></textarea>

        <button type="submit" class="cs-submit">Enviar Mensaje</button>
      </form>
    </div>
  </section>

</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>

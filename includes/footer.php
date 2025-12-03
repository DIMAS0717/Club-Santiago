<!-- ==================== FOOTER VILLAS EUREKA ==================== -->
<footer class="ve-footer">
  <div class="ve-footer-inner">

    <!-- Logo + nombre -->
    <div class="ve-footer-logo">
      <!-- IGUANA / LOGO PRINCIPAL -->
      <img src="assets/images/logofoter.png" alt="Villas Eureka" class="ve-logo-img">
    </div>

    <!-- Columna: Contacto -->
    <!-- Columna: Contacto -->
<div class="ve-footer-card card-contacto">

  <h3>Contáctanos</h3>

  <!-- EMAIL -->
  <div class="ve-contact-item">
    <img src="assets/images/mail-icon.png" class="ve-icon-img">
    <a href="mailto:goyorealestate@gmail.com">goyorealestate@gmail.com</a>
  </div>

  <!-- TELÉFONO -->
  <div class="ve-contact-item">
    <img src="assets/images/telephone-icon.png" class="ve-icon-img">
    <div>
      <p>(314) 355 0525</p>
      <p>(314) 355 0026</p>
      <p>(514) 334 1085</p>
    </div>
  </div>

  <!-- DIRECCIÓN -->
  <div class="ve-contact-item">
    <img src="assets/images/location-icon.png" class="ve-icon-img">
    <p>
      Calle Deltin D-05, Fracc. Club Santiago,<br>
      Manzanillo, Colima, MX. C.P. 28868
    </p>
  </div>

</div>


    <!-- Columna: Conóce más -->
    <div class="ve-footer-card card-links">

      <h3>Conóce más</h3>
      <ul class="ve-links">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="renta.php">Propiedades en renta</a></li>
        <li><a href="venta.php">Propiedades en venta</a></li>
        <li><a href="villas.php">Nuestras villas</a></li>
        <li><a href="alrededores.php">Alrededores</a></li>
        <li><a href="contacto.php">Contáctanos</a></li>
      </ul>
    </div>

    <!-- Columna: Síguenos + horarios -->
    <div class="ve-footer-card card-social">

      <h3>Síguenos</h3>
      <div class="ve-social-row">

  <a href="https://www.facebook.com/villaseurekamanzanillo/" class="ve-social-circle">
    <img src="./assets/images/facebookicon.png" alt="Facebook">
  </a>

  <a href="https://www.instagram.com/villaseurekamanzanillo?igsh=bXR2c3o0Ync2cjF4" class="ve-social-circle">
    <img src="./assets/images/instagramicon.png" alt="Instagram">
  </a>

  <a href="https://www.tiktok.com/@villas.eureka?_r=1&_t=ZS-91ro2KUHMM3" class="ve-social-circle">
    <img src="./assets/images/tiktokicon.png" alt="WhatsApp">
  </a>

</div>



      <h4>Horarios</h4>
      <p>Lun - Vier: 9 AM - 7 PM</p>
      <p>Sab - Dom: 10 AM - 6 PM</p>
    </div>
  </div>

  <!-- Línea inferior con iguana pequeña -->
  <div class="ve-footer-bottom">
    <span class="ve-bottom-line"></span>

    <!-- IGUANA PEQUEÑA -->
    <img src="assets/images/lagartija.png" alt="Iguana Villas Eureka" class="ve-iguana-mini">

    <span class="ve-bottom-line"></span>
  </div>
</footer>
<!-- ================== FIN FOOTER VILLAS EUREKA ================== -->

<style>
:root {
  --ve-blue-dark: #0e3564;
  --ve-blue-mid: #1c4f83;
  --ve-card-bg: rgba(5, 36, 76, 0.9);
  --ve-text-main: #ffffff;
  --ve-text-muted: #d8e4f5;
  --ve-border-soft: #6fb8ff;
}


.ve-footer {
  background: linear-gradient(135deg, #3D5477, #173457);
  color: var(--ve-text-main);
  padding: 20px 30px 14px;
  width: 100%;
  margin-top: 0 !important;
  max-width: none;
  margin: 60px 0 0;   /* arriba sí, pero sin auto a los lados */
  border-radius: 0;   /* sin esquinas redondeadas para que llegue a los bordes */
  box-shadow: none;   /* opcional: quita la sombra para que parezca barra */
}

.ve-social-row {
  display: flex;
  gap: 12px;
}

.ve-social-circle {
  width: 50px;
  height: 50px;
  border: 2px solid #FFFFFF; /* borde blanco */
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  text-decoration: none;
}

.ve-social-circle img {
  width: 28px;        /* tamaño grande */
  height: 28px;
  object-fit: contain;
  filter: brightness(0) invert(1); /* convertir a blanco */
}


.ve-icon-img {
  width: 22px;
  height: 22px;
  filter: invert(100%); /* convierte negro → blanco */
}


.ve-contact-item {
  display: flex;
  gap: 12px;
  margin-bottom: 12px;
  align-items: flex-start;
}

/* CONTACTO — Azul suave */
.card-contacto {
  background: #3D5477; /* azul claro estilo eureka */
}

/* CONÓCE MÁS — Azul medio */
.card-links {
  background: #3D5477;
}

/* SÍGUENOS — Azul más profundo */
.card-social {
  background: #3D5477;
}




.ve-footer-inner {
  display: flex;
  align-items: stretch;
  gap: 24px;
}

.ve-footer-logo {
  display: flex;
  align-items: center;
  justify-content: center;
  padding-right: 2px;
}

.ve-logo-img {
  max-width: 230px;
  height: auto;
}

/* Tarjetas */
.ve-footer-card {
  flex: 1;
  border-radius: 16px;
  padding: 18px 20px;
  box-shadow: 0 14px 25px rgba(0, 0, 0, 0.4);
  font-size: 14px;
}

.ve-footer-card h3 {
  margin: 0 0 14px;
  font-size: 16px;
  font-weight: 700;
}

.ve-footer-card h4 {
  margin: 20px 0 6px;
  font-size: 15px;
  font-weight: 700;
}

.ve-footer-card p {
  margin: 0 0 4px;
  color: var(--ve-text-muted);
}

/* Contacto */
.ve-contact-item {
  display: flex;
  gap: 10px;
  margin-bottom: 10px;
}

.ve-icon {
  font-size: 18px;
  line-height: 1.2;
}

.ve-contact-item a,
.ve-contact-item p {
  color: var(--ve-text-muted);
  text-decoration: none;
}

/* Links */
.ve-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.ve-links li {
  margin-bottom: 4px;
}

.ve-links a {
  text-decoration: none;
  color: var(--ve-text-muted);
  font-size: 14px;
}

.ve-links a:hover {
  text-decoration: underline;
}

/* Redes */
.ve-social-row {
  display: flex;
  gap: 10px;
  margin-bottom: 14px;
}

.ve-social-circle {
  width: 34px;
  height: 34px;
  border-radius: 999px;
  border: 1.5px solid var(--ve-text-main);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  text-decoration: none;
  color: var(--ve-text-main);
}

/* Parte inferior */
.ve-footer-bottom {
  margin-top: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
}

.ve-bottom-line {
  flex: 1;
  height: 1px;
  background: #fff;
}

.ve-iguana-mini {
  height: 70px;
  width: auto;
}

/* Responsive */
@media (max-width: 900px) {
  .ve-footer-inner {
    flex-wrap: wrap;
  }
  .ve-footer-logo {
    flex-basis: 100%;
    justify-content: center;
    margin-bottom: 10px;
  }
}
</style>

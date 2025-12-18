<link rel="stylesheet" href="./assets/header.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<header class="header-full">
    <div class="header-container">

        <!-- LOGO -->
        <div class="header-logo">
            <img src="./assets/images/logofoter.png" alt="Logo Club Santiago">
            <span>Villas Eureka</span>
        </div>

        <?php 
  //NECESITAMOS OBTENER EL ARCHIVO EN EL QUE ESTAMOS PARA DIBUJAR NUESTRO ENLACE CON CSS
  $current_page = basename($_SERVER['PHP_SELF']); 
?>

<nav class="header-nav">
    <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Inicio</a>
    
    <a href="renta.php" class="<?php echo ($current_page == 'renta.php') ? 'active' : ''; ?>">Propiedades en renta</a>
    
    <a href="venta.php" class="<?php echo ($current_page == 'venta.php') ? 'active' : ''; ?>">Propiedades en venta</a>
    
    <a href="villas.php" class="<?php echo ($current_page == 'villas.php') ? 'active' : ''; ?>">Nuestras villas</a>
    
    <a href="alrededores.php" class="<?php echo ($current_page == 'alrededores.php') ? 'active' : ''; ?>">Alrededores</a>
    
    <a href="contacto.php" class="<?php echo ($current_page == 'contacto.php') ? 'active' : ''; ?>">Contáctanos</a>
</nav>

        <!-- ACCIONES -->
        <div class="header-actions">
            <button id="themeToggle" class="toggle-theme">🌙</button>
            <a href="admin/login.php" class="admin-dot"></a>
        </div>

    </div>
    <script>
        window.addEventListener('scroll', function() {
    const header = document.querySelector('.header-full');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});
    </script>
</header>

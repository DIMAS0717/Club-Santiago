// ====== MODO OSCURO / CLARO ======//
(function () {
  const body = document.body;
  const btn = document.getElementById('themeToggle');
  if (!btn) return;

  const saved = localStorage.getItem('club_theme');
  if (saved === 'dark') {
    body.classList.add('dark');
    btn.textContent = '☀️';
  }

  btn.addEventListener('click', () => {
    const isDark = body.classList.toggle('dark');
    btn.textContent = isDark ? '☀️' : '🌙';
    localStorage.setItem('club_theme', isDark ? 'dark' : 'light');
  });
})();

//================Slider(Carrusel de inicio)====================//
(function () {
  const right = document.querySelector(".ve-right");
  const left = document.querySelector(".ve-left");
  const veSlides = document.querySelectorAll(".ve-slide");

  if (!right || !left || veSlides.length === 0) return;

  let index = 0;

  function showSlide(i) {
    veSlides.forEach(s => s.classList.remove("active"));
    veSlides[i].classList.add("active");
  }

  right.onclick = () => {
    index = (index + 1) % veSlides.length;
    showSlide(index);
  };

  left.onclick = () => {
    index = (index - 1 + veSlides.length) % veSlides.length;
    showSlide(index);
  };

  setInterval(() => {
    index = (index + 1) % veSlides.length;
    showSlide(index);
  }, 6000);
})();

// ====== VALIDACIÓN DE CONTRASEÑA EN PANEL ======//
(function () {
  const pwd = document.getElementById('passwordNueva');
  const strength = document.getElementById('passwordStrength');
  if (!pwd || !strength) return;

  pwd.addEventListener('input', () => {
    const value = pwd.value;
    let score = 0;
    if (value.length >= 8) score++;
    if (/[a-z]/.test(value)) score++;
    if (/[A-Z]/.test(value)) score++;
    if (/\d/.test(value)) score++;

    let msg = 'Contraseña débil';
    if (score === 4) msg = 'Contraseña segura ✔';
    else if (score === 3) msg = 'Contraseña aceptable';
    strength.textContent = msg;
  });
})();

// ====== SLIDER GALERÍA PROPIEDAD ======//
(function () {
  const slider = document.querySelector('[data-slider="property"]');
  if (!slider) return;

  const track = slider.querySelector('[data-slider-track]');
  const slides = Array.from(slider.querySelectorAll('[data-slide]'));
  const dots = Array.from(slider.querySelectorAll('[data-dot]'));
  const btnPrev = slider.querySelector('[data-prev]');
  const btnNext = slider.querySelector('[data-next]');

  if (!track || slides.length === 0) return;

  let index = 0;

  function goTo(i) {
    index = (i + slides.length) % slides.length;
    track.style.transform = 'translateX(-' + (index * 100) + '%)';
    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === index);
    });
  }

  btnPrev && btnPrev.addEventListener('click', () => goTo(index - 1));
  btnNext && btnNext.addEventListener('click', () => goTo(index + 1));
  dots.forEach((dot, idx) => {
    dot.addEventListener('click', () => goTo(idx));
  });

  goTo(0);
})();


// ====== LIGHTBOX CONTIENE NAVEGACIÓN Y CONTADOR ====== //
document.addEventListener("DOMContentLoaded", function () {

  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  const btnPrev = document.querySelector('.lightbox-prev');
  const btnNext = document.querySelector('.lightbox-next');
  const counter = document.getElementById('lightbox-counter');

  if (!lightbox || !lightboxImg || !btnPrev || !btnNext || !counter) {
    return; // ⛔ No existe lightbox en esta página
  }

  const images = [
    ...document.querySelectorAll('.gallery-img'),
    ...document.querySelectorAll('.slider-img')
  ];

  let currentIndex = 0;

  function updateCounter() {
    counter.textContent = `${currentIndex + 1} / ${images.length}`;
  }

  function openLightbox(index) {
    currentIndex = index;
    lightboxImg.src = images[currentIndex].src;
    updateCounter();
    lightbox.classList.add('active');
  }

  lightbox.addEventListener('click', e => {
    if (e.target === lightbox) lightbox.classList.remove('active');
  });

  btnPrev.addEventListener('click', e => {
    e.stopPropagation();
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    lightboxImg.src = images[currentIndex].src;
    updateCounter();
  });

  btnNext.addEventListener('click', e => {
    e.stopPropagation();
    currentIndex = (currentIndex + 1) % images.length;
    lightboxImg.src = images[currentIndex].src;
    updateCounter();
  });

  images.forEach((img, i) => {
    img.style.cursor = 'pointer';
    img.addEventListener('click', () => openLightbox(i));
  });

  document.addEventListener('keydown', e => {
    if (e.key === "Escape") lightbox.classList.remove('active');
  });
});

// Esperar a que el documento esté cargado
document.addEventListener('DOMContentLoaded', () => {

    // Seleccionamos todos los botones de "Ver Alberca"
    const poolButtons = document.querySelectorAll('.btn-view-pool');

    poolButtons.forEach(boton => {
        boton.addEventListener('click', function(e) {
            // 1. Evitamos que el navegador siga el enlace <a> de la tarjeta
            e.preventDefault(); 
            
            // 2. Evitamos que el clic se propague a otros elementos
            e.stopPropagation(); 

            // 3. Buscamos el contenedor padre (el wrapper de la imagen)
            const wrapper = this.closest('.home-property-img-wrapper');
            
            // 4. Alternamos la clase para deslizar la imagen
            if (wrapper) {
                wrapper.classList.toggle('show-pool');
            }
        });
    });

});
// Asegúrate de que este JavaScript esté en tu archivo
document.addEventListener('DOMContentLoaded', function() {
  // Obtener elementos
  const modal = document.getElementById("mapModal");
  const modalImg = document.getElementById("mapModalImg");
  const openMapBtn = document.getElementById("openMap");
  const closeBtn = document.querySelector(".map-close");
  
  // Si existe el botón para abrir el mapa
  if (openMapBtn) {
    openMapBtn.onclick = function() {
      modal.style.display = "block";
      modalImg.src = this.src;
      modalImg.alt = this.alt;
      // Prevenir scroll del body
      document.body.style.overflow = "hidden";
    }
  }
  
  // Cerrar al hacer click en la X
  if (closeBtn) {
    closeBtn.onclick = function() {
      modal.style.display = "none";
      document.body.style.overflow = "auto";
    }
  }
  
  // Cerrar al hacer click fuera de la imagen
  modal.onclick = function(event) {
    if (event.target === modal || event.target.classList.contains('map-modal-content')) {
      modal.style.display = "none";
      document.body.style.overflow = "auto";
    }
  }
  
  // Cerrar con tecla ESC
  document.addEventListener('keydown', function(event) {
    if (event.key === "Escape" && modal.style.display === "block") {
      modal.style.display = "none";
      document.body.style.overflow = "auto";
    }
  });
});
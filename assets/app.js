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
let veSlides = document.querySelectorAll(".ve-slide");
let index = 0;

function showSlide(i) {
  veSlides.forEach(s => s.classList.remove("active"));
  veSlides[i].classList.add("active");
}

document.querySelector(".ve-right").onclick = () => {
  index = (index + 1) % veSlides.length;
  showSlide(index);
};

document.querySelector(".ve-left").onclick = () => {
  index = (index - 1 + veSlides.length) % veSlides.length;
  showSlide(index);
};

// Auto-slide
setInterval(() => {
  index = (index + 1) % veSlides.length;
  showSlide(index);
}, 6000);


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

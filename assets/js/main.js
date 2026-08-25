// BIA — site behaviour
(function () {
  // Sticky header shadow
  var header = document.querySelector('.header');
  window.addEventListener('scroll', function () {
    header && header.classList.toggle('scrolled', window.scrollY > 12);
  });

  // Mobile nav
  var burger = document.querySelector('.burger');
  var nav = document.querySelector('.nav');
  if (burger && nav) {
    burger.addEventListener('click', function () { nav.classList.toggle('open'); });
    nav.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () { nav.classList.remove('open'); });
    });
  }

  // Hero slider
  var slides = document.querySelectorAll('.hero-slide');
  var dotsWrap = document.querySelector('.hero-dots');
  if (slides.length) {
    var cur = 0, timer;
    slides.forEach(function (_, i) {
      var b = document.createElement('button');
      b.setAttribute('aria-label', 'Slide ' + (i + 1));
      if (i === 0) b.className = 'active';
      b.addEventListener('click', function () { go(i); restart(); });
      dotsWrap.appendChild(b);
    });
    var dots = dotsWrap.querySelectorAll('button');
    function go(i) {
      slides[cur].classList.remove('active'); dots[cur].classList.remove('active');
      cur = i % slides.length;
      slides[cur].classList.add('active'); dots[cur].classList.add('active');
    }
    function restart() { clearInterval(timer); timer = setInterval(function () { go(cur + 1); }, 5000); }
    restart();
  }

  // Reveal on scroll
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
  }, { threshold: 0.12 });
  document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });

  // Affiliation cards with data-link / data-pdf
  document.querySelectorAll('[data-link]').forEach(function (c) {
    c.addEventListener('click', function () { window.open(c.getAttribute('data-link'), '_blank', 'noopener'); });
  });
})();

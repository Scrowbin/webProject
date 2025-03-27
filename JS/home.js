// Navbar scroll effect
window.addEventListener('scroll', function() {
  const navbar = document.querySelector('.navbar');
  if (window.scrollY > 80) {
    navbar.classList.add('scrolled');
  } else {
    navbar.classList.remove('scrolled');
  }
});

const carouselInner = document.querySelector('.carousel-inner');
const items = carouselInner.querySelectorAll('.carousel-item');
const indicators = document.querySelectorAll('.carousel-indicators li');
const prevControl = document.querySelector('.carousel-control-prev');
const nextControl = document.querySelector('.carousel-control-next');

let currentIndex = 0;

function setActiveItem(index) {
  items[currentIndex].classList.remove('active');
  indicators[currentIndex].classList.remove('active');
  currentIndex = index;
  items[currentIndex].classList.add('active');
  indicators[currentIndex].classList.add('active');
}

prevControl.addEventListener('click', (e) => {
  e.preventDefault();
  let newIndex = (currentIndex - 1 + items.length) % items.length;
  setActiveItem(newIndex);
});

nextControl.addEventListener('click', (e) => {
  e.preventDefault();
  let newIndex = (currentIndex + 1) % items.length;
  setActiveItem(newIndex);
});

indicators.forEach((indicator, index) => {
  indicator.addEventListener('click', () => {
    setActiveItem(index);
  });
});
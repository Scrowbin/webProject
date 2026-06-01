// Navbar scroll effect
// window.addEventListener('scroll', function() {
//   const navbar = document.querySelector('.navbar');
//   navbar.classList.toggle('scrolled', window.scrollY > 80);
// });

// Handle responsive layout
function handleResponsiveLayout() {
  const width = window.innerWidth;
  const mainContainer = document.querySelector('.main-container');
  
  // Bootstrap breakpoints and corresponding container widths
  const breakpoints = [
    { width: 576, maxWidth: '100%' },
    { width: 768, maxWidth: '540px' },
    { width: 992, maxWidth: '720px' },
    { width: 1200, maxWidth: '960px' },
    { width: 1400, maxWidth: '1140px' },
    { width: Infinity, maxWidth: '1320px' }
  ];
  
  // Find the appropriate max-width based on current screen width
  const breakpoint = breakpoints.find(bp => width < bp.width);
  mainContainer.style.maxWidth = breakpoint.maxWidth;
}

// Run on page load and resize
window.addEventListener('load', handleResponsiveLayout);
window.addEventListener('resize', handleResponsiveLayout);

document.addEventListener('DOMContentLoaded', function () {
    // // Navbar scroll effect - REMOVED
    // const navbar = document.querySelector('.navbar');
    // window.addEventListener('scroll', () => {
    //     if (window.scrollY > 50) { // Adjust scroll distance as needed
    //         navbar.classList.add('scrolled');
    //     } else {
    //         navbar.classList.remove('scrolled');
    //     }
    // });

    // // Sidebar toggle functionality - REMOVED
    // const hamburgerBtn = document.getElementById('hamburger-btn');
    // const closeBtn = document.querySelector('#nav-sidebar .close-btn'); // Find close button within sidebar
    // const bodyElement = document.body;

    // if (hamburgerBtn) {
    //     hamburgerBtn.addEventListener('click', () => {
    //         bodyElement.classList.add('sidebar-open'); // Use add, not toggle
    //     });
    // }

    // if (closeBtn) {
    //     closeBtn.addEventListener('click', () => {
    //         bodyElement.classList.remove('sidebar-open'); // Close button removes the class
    //     });
    // }

    // // User Modal functionality - REMOVED
    // const userAvatarBtn = document.getElementById('user-avatar-btn');
    // const userModalElement = document.getElementById('user-modal');
    
    // if (userAvatarBtn && userModalElement) {
    //   const userModal = new bootstrap.Modal(userModalElement);
      
    //   userAvatarBtn.addEventListener('click', () => {
    //     userModal.show();
    //   });
    // }

    // Initialize Featured Manga Carousel
    const featuredCarouselElement = document.getElementById('featuredMangaCarousel');
    if (featuredCarouselElement) {
      const featuredCarousel = new bootstrap.Carousel(featuredCarouselElement, {
        interval: false, // Explicitly disable auto-sliding
        wrap: true // Allow wrapping from last to first slide
      });
    }

    // Example: Initialize Bootstrap Carousel if needed
    // const myCarousel = document.getElementById('mangaCarousel');
    // if (myCarousel) {
    //     new bootstrap.Carousel(myCarousel, {
    //         interval: 5000,
    //         wrap: true
    //     });
    // }
});

// Helper function to initialize Swiper and add wheel stopper
function initializeSwiper(containerSelector, paginationSelector, nextButtonSelector) {
  const swiperInstance = new Swiper(containerSelector, {
    direction: 'horizontal',
    loop: true,
    slidesPerView: 5,
    spaceBetween: 12,
    slidesPerGroup: 1,
    speed: 400,
    mousewheel: true,
    pagination: {
      el: paginationSelector,
      clickable: true,
      dynamicBullets: true,
    },
    navigation: {
      nextEl: nextButtonSelector,
    },
    breakpoints: {
      320: { slidesPerView: 2, spaceBetween: 8 },
      576: { slidesPerView: 3, spaceBetween: 10 },
      768: { slidesPerView: 4, spaceBetween: 12 },
      992: { slidesPerView: 5, spaceBetween: 12 }
    }
  });

  // Prevent mousewheel scroll on description boxes within this swiper
  const swiperContainer = document.querySelector(containerSelector);
  if (swiperContainer) {
    const descriptionBoxes = swiperContainer.querySelectorAll('.description-box');
    descriptionBoxes.forEach(box => {
      box.addEventListener('wheel', function(event) {
        event.stopPropagation();
      });
    });
  }
}

// Initialize All Swipers on DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
  initializeSwiper('.staff-picks-swiper', '.staff-picks-pagination', '.staff-picks-next');
  initializeSwiper('.self-published-swiper', '.self-published-pagination', '.self-published-next');
  initializeSwiper('.featured-items-swiper', '.featured-items-pagination', '.featured-items-next');
  initializeSwiper('.recently-added-swiper', '.recently-added-pagination', '.recently-added-next');

  // --- Dynamic Background for Featured Carousel ---
  const featuredCarouselElement = document.getElementById('featuredMangaCarousel');
  const backgroundSection = document.querySelector('.popular-new-titles-section');

  if (featuredCarouselElement && backgroundSection) {
      const updateBackground = (slideElement) => {
          const featuredManga = slideElement.querySelector('.featured-manga');
          if (featuredManga) {
              const bgUrl = featuredManga.dataset.bgSrc;
              if (bgUrl) {
                  // Preserve the gradient overlay for readability
                  backgroundSection.style.backgroundImage = `linear-gradient(rgba(17, 17, 17, 0.85), rgba(17, 17, 17, 0.95)), url('${bgUrl}')`;
              }
          }
      };

      // Set initial background on load
      const initialActiveSlide = featuredCarouselElement.querySelector('.carousel-item.active');
      if (initialActiveSlide) {
          updateBackground(initialActiveSlide);
      }

      // Update background on slide change
      featuredCarouselElement.addEventListener('slide.bs.carousel', function (event) {
          // event.relatedTarget is the slide that will be shown
          updateBackground(event.relatedTarget);
      });
  }
  // --- End Dynamic Background ---
});


  var swiper1 = new Swiper(".popular_swiper", {
    slidesPerView: 1, 
    spaceBetween: 20, 
    loop: true,       
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });
  var swiper2 = new Swiper('.image-name-swiper', {
    slidesPerView: 3, 
    spaceBetween: 20,  
    loop: true,        
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
  });
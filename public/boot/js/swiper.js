// swiper.js

var swiper = new Swiper('.clients-slider', {
    slidesPerView: 3,
    spaceBetween: 18,
    loop: true,
    autoplay:false,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
    }
  });
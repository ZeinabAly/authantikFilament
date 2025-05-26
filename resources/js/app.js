import './bootstrap';
import './header.js';
import './interfaceUser/index.js';
import './interfaceUser/about.js';

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();


// SWIPER POUR LA PAGE INDEX ET VIEW PRODUCT
document.addEventListener('DOMContentLoaded', function() {
    const productSwiper = new Swiper('.swiper', {
      effect: 'slide',
      loop: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      slidesPerView: 'auto',
      spaceBetween: 20,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        slidesPerView: 6,
      }
    });
});
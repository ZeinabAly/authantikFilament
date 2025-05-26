import './bootstrap';
import './header.js';
import './interfaceUser/index.js';
import './interfaceUser/about.js';

// import Swiper from 'swiper/bundle';


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


    // SWIPER POUR LA PAGE VIEW PRODUCT
    // const swiper2 = new Swiper('.swiper2', {
    //   effect: 'slide',
    //   loop: true,
    //   autoplay: {
    //     delay: 5000,
    //     disableOnInteraction: false,
    //   },
    //   slidesPerView: 'auto',
    //   spaceBetween: 20,
    //   pagination: {
    //     el: '.swiper-pagination',
    //     clickable: true,
    //   },
    //   navigation: {
    //     nextEl: '.swiper-button-next',
    //     prevEl: '.swiper-button-prev',
    //   },
    //   breakpoints: {
    //     slidesPerView: 1,
    //   }
    // });

});
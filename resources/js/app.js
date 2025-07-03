import './bootstrap';
import './header.js';
import './interfaceUser/index.js';
import './interfaceUser/about.js';

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();

import Swiper from 'swiper/bundle';
import 'swiper/css/bundle'; // Styles complets


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
    });
  
});


//********************** SCROLLREVEAL **************************/
document.addEventListener('DOMContentLoaded', function(){
    
  // SCROLL REVEAL
  // Initialisation de ScrollReveal
  const sr = ScrollReveal({
    origin: 'bottom', // Point d'origine de l'animation ('top', 'right', 'bottom', 'left')
    distance: '50px', // Distance parcourue par l'élément
    duration: 1000,   // Durée de l'animation (en ms)
    delay: 200,       // Délai avant de commencer l'animation (en ms)
    reset: true      // Si 'true', l'animation se rejoue au scroll
  });

  // Application de l'animation sur différents éléments
  sr.reveal('.revealTop', { origin: 'top', delay: 300 });
  sr.reveal('.revealLeft', { origin: 'left', distance: '100px', delay: 500 });
  sr.reveal('.revealBottom', { origin: 'bottom', delay: 400, duration: 1200 });
  sr.reveal('.revealRight', { origin: 'right', distance: '70px', delay: 600 });



// topBottom
  const topBottom = ScrollReveal({
  distance: '50px',   // Distance de l'animation
  duration: 800,      // Durée de l'animation (en ms)
  easing: 'ease-out', // Effet de l'animation
  reset: true,        // Rejoue l'animation à chaque scroll
  });

  // Animation des éléments venant du haut
  topBottom.reveal('.from-top', {
  origin: 'top',     // Vient du haut
  interval: 200,     // Délai entre chaque élément
  });

  // Animation des éléments venant du bas
  topBottom.reveal('.from-bottom', {
  origin: 'bottom',  // Vient du bas
  interval: 200,     // Délai entre chaque élément
  });

})
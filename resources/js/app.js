import './bootstrap';
import './header.js';
import './admin/sidebar.js';
import './admin/modal.js';
import './interfaceUser/index.js';
import './interfaceUser/about.js';

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();

// window.addEventListener('DOMContentLoaded', function(){
    
//     deletebtn.forEach(btn => {
//         btn.addEventListener('click', (e) => {
            
//             e.preventDefault();
//             const form = e.target.closest("form");
//             console.log('yes');
            
        
//         swal({
//             title: "Etes vous sûr?",
//             text: "Voulez-vous vraiment supprimer ? ",
//             // icon: "warning",
//             buttons: {
//                 cancel: "Non",
//                 confirm: "Oui",
//             },
//             dangerMode: true,
//             })
//             .then((willDelete) => {
//             if (willDelete) {
//                 swal("Poof! Suppression effectuée !", {
//                 icon: "success",
//                 });
//                 form.submit();
//             } else {
//                 swal("Suppression annulée !");
//             }
//         });
//         })
//     });


// })

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
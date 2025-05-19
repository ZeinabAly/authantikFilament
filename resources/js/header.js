document.addEventListener('DOMContentLoaded', function(){

    const header = document.getElementById('header');
    const mobile = document.getElementById('header-mobile');
    let panier = document.querySelector('.panier');
    let userLogin = document.querySelector('.userLogin');
    let wishlist = document.querySelector('.wishlist');
    let topHeader = document.querySelector('.topHeader');
    let headerIcons = document.querySelectorAll('.headerIcon');
    
    // console.log(document.querySelectorAll('.headerIcon'));
    
    function changeHeaderIconsColorBlack(){
      headerIcons.forEach(icon => {
        icon.setAttribute('fill', "#000")
        icon.setAttribute('stroke', "#000")
      });
    }
    function changeHeaderIconsColorWhite(){
      headerIcons.forEach(icon => {
        icon.setAttribute('fill', "#fff")
        icon.setAttribute('stroke', "#fff")
      });
    }

    window.addEventListener('scroll', function(){
        if(window.scrollY >= 120){
            topHeader.style.display = "none";
            header.classList.add('header-sticky')
            mobile.classList.add('header-sticky')
            changeHeaderIconsColorBlack();
            
        }else{
            topHeader.style.display = "flex";
            header.classList.remove('header-sticky')
            mobile.classList.remove('header-sticky')
            changeHeaderIconsColorWhite()
        }
        
    })

    // Bouton Open
    const openBtn = document.getElementById('openBtn');
    const navbar = document.querySelector('.header-sidebar');
    const overlay = document.querySelector('.overlay');
    const closeBtn = document.querySelector('.closeBtn');
    
    
    
    openBtn.addEventListener('click', function(){
        navbar.classList.toggle('navbar');
        overlay.classList.add('overlayActive');
        if(navbar.classList.contains('navbar')){
            document.body.classList.add('scrollHidden');
        }else{
            document.body.classList.remove('scrollHidden');
        }
    })

    
    closeBtn.addEventListener('click', function(){
        navbar.classList.remove('navbar');
        overlay.classList.remove('overlayActive');
        document.body.classList.remove('scrollHidden');
    })

    // HEADER SLIDER

    
const heroSlider = document.querySelector("[data-hero-slider]");
const heroSliderItems = document.querySelectorAll("[data-hero-slider-item]");
const heroSliderPrevBtn = document.querySelector("[data-prev-btn]");
const heroSliderNextBtn = document.querySelector("[data-next-btn]");



let currentSlidePos = 0;
let lastActiveSliderItem = heroSliderItems[0];

const updateSliderPos = function () {
    lastActiveSliderItem.classList.remove("active");
    heroSliderItems[currentSlidePos].classList.add("active");
    lastActiveSliderItem = heroSliderItems[currentSlidePos];
}

const slideNext = function () {
  if (currentSlidePos >= heroSliderItems.length - 1) {
    currentSlidePos = 0;
  } else {
    currentSlidePos++;
  }

  updateSliderPos();
}



heroSliderNextBtn.addEventListener("click", slideNext);

const slidePrev = function () {
  if (currentSlidePos <= 0) {
    currentSlidePos = heroSliderItems.length - 1;
  } else {
    currentSlidePos--;
  }

  updateSliderPos();
}


heroSliderPrevBtn.addEventListener("click", slidePrev);

/**
 * auto slide
 */

let autoSlideInterval;

const autoSlide = function () {
  autoSlideInterval = setInterval(function () {
    slideNext();
  }, 7000);
}

autoSlide();

// heroSliderNextBtn.addEventListener('mouseover', function(){
//     clearInterval(autoSlideInterval);
// })
// heroSliderPrevBtn.addEventListener('mouseover', function(){
//     clearInterval(autoSlideInterval);
// })
// heroSliderNextBtn.addEventListener('autoSlide', function(){
//     clearInterval(autoSlideInterval);
// })
// heroSliderPrevBtn.addEventListener('autoSlide', function(){
//     clearInterval(autoSlideInterval);
// })



})




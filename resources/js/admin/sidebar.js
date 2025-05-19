
document.addEventListener('DOMContentLoaded', function(){
    var iconRight = document.querySelector('.icon-right');
    var mainContent = document.querySelector('.mainContent');
    var adminSidebar = document.querySelector('.adminSidebar');
    var navIcons = document.querySelectorAll('.navIcon');
    var navTexts = document.querySelectorAll('.navText');
    var logo = document.querySelector('.logoBox .logo');
    var userImgContent = document.querySelector('.userImgContent');

    // Pour les grands écrans
    if(window.innerWidth > 680 ){
        grandEcrans();
        iconRight.removeEventListener('click', clickIconRightSmallScreen);
    }else{ 
        petitEcrans();
        iconRight.removeEventListener('click', clickIconRightLargeScreen)
    }
    
    
    window.addEventListener('resize', function(){
        if(window.innerWidth <= 680 ){
            petitEcrans();
            resizeNavIcons();
            iconRight.removeEventListener('click', clickIconRightLargeScreen)
        }
        else if(window.innerWidth > 680 ){
            grandEcrans();
            resizeNavIcons();
            iconRight.removeEventListener('click', clickIconRightSmallScreen);
        }
    });

    function petitEcrans(){
        adminSidebar.classList.add('leftClick');
        mainContent.classList.add('fullContent');
        // orderModal.classList.add('fullContentModal');
        logo.classList.add('logoNone');
        userImgContent.classList.add('userImgNone');

        iconRight.classList.add("iconRight"); //l'icone se retourne a droite

        navIcons.forEach(navIcon => {
            navIcon.setAttribute('width', '20');
            navIcon.setAttribute('height', '20');
            navIcon.classList.add('styleIcon'); //marge des icones
        });

        navTexts.forEach(navText => {
            navText.classList.add('navText'); //faire disparaitre les textes
        });

        iconRight.addEventListener('click', clickIconRightSmallScreen);
    }


    function grandEcrans(){
        
        adminSidebar.classList.remove('leftClick');
        mainContent.classList.remove('fullContent');
        // orderModal.classList.remove('fullContentModal');
        logo.classList.remove('logoNone');
        userImgContent.classList.remove('userImgNone');
        navTexts.forEach(navText => {
            navText.classList.remove('navText');
        });

        iconRight.classList.remove("iconRight");

        iconRight.addEventListener('click', clickIconRightLargeScreen);
    }


// **** LES SOUS FONCTIONS **** //
    // FONCTION POUR MODIFIER LA TAILLE DES ICONS AU CLICK DE LA SIDEBAR
    function resizeNavIcons() {
        
        navIcons.forEach(navIcon => {

            if(adminSidebar.classList.contains('leftClick')){
                navIcon.setAttribute('width', '20');
                navIcon.setAttribute('height', '20');
                navIcon.classList.add('styleIcon');
            }else{
                navIcon.setAttribute('width', '16');
                navIcon.setAttribute('height', '16');
                navIcon.classList.remove('styleIcon');
            }
        });
    }


    // Gestion du click pour les petits écrans 
    function clickIconRightSmallScreen(){
        adminSidebar.classList.toggle('sideBarOverlay');
        adminSidebar.classList.toggle('leftClick');
        logo.classList.toggle('logoNone');
        userImgContent.classList.toggle('userImgNone');
        
        // FONCTION POUR MODIFIER LA TAILLE DES ICONS AU CLICK DE LA SIDEBAR
        resizeNavIcons();

        iconRight.classList.toggle("iconRight");
        navTexts.forEach(navText => {
            navText.classList.toggle('navText');
        });
    }


    // GESTION DU CLICK DE RIGHT ICON POUR LES GRANDS ECRANS
    function clickIconRightLargeScreen(){
        adminSidebar.classList.remove('sideBarOverlay');
        adminSidebar.classList.toggle('leftClick');
        logo.classList.toggle('logoNone');
        userImgContent.classList.toggle('userImgNone');
        mainContent.classList.toggle('fullContent');
        // orderModal.classList.add('fullContentModal');
        iconRight.classList.toggle("iconRight");
        
        // FONCTION POUR MODIFIER LA TAILLE DES ICONS AU CLICK DE LA SIDEBAR
        resizeNavIcons();

        navTexts.forEach(navText => {
            navText.classList.toggle('navText');
        });
    }

// **** FIN LES SOUS FONCTIONS **** //


    // LES REGLAGES DE LA MODALE
    // var btnCommander = document.querySelector('.btnCommander');
    // var closeModalBtn = document.querySelector('.closeModalBtn');
    // var orderModal = document.querySelector('.modalContent .orderModal');
    // var body = document.body;
    
    // orderModal.classList.add('orderModalNone');
    // btnCommander.addEventListener('click', function(){
        // orderModal.classList.remove('orderModalNone');
        // orderModal.style.display = "block";
        // body.classList.add('bodyScrollNone');
        
    // });
    // closeModalBtn.addEventListener('click', function(){
    //     // orderModal.style.display = "none";
    //     orderModal.classList.add('orderModalNone');
    // });
    

});

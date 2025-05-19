document.addEventListener('DOMContentLoaded', function(){

    var btnModalCategories = document.querySelectorAll('.btnModalCategory');
    // console.log(btnModalCategories);
    btnModalCategories.forEach(btnModalCategory => {
        btnModalCategory.classList.remove('bgGreen');
        btnModalCategory.addEventListener('click', function(){
            
            btnModalCategories.forEach(btnModalCategory => {
                btnModalCategory.classList.remove('bgGreen');
            });
            
            btnModalCategory.classList.add('bgGreen');
        });
        
    });

    const paymentButtons = document.querySelectorAll('button.modePayment[wire\\:click]');


    // var modePayments = document.querySelector('.modePayment');
    // console.log(modePayments);
    
    // modePayments.forEach(modePayment => {
    //     modePayment.classList.remove('bgGreen');
    //     modePayment.addEventListener('click', function(){
    //         alert('');
    //         btnModalCategories.forEach(modePayment => {
    //             modePayment.classList.remove('bgGreen');
    //         });
            
    //         modePayment.classList.add('bgGreen');
    //     });
        
    // });
    


    // Faire disparaitre les message d'erreur après un certain moment
    // document.addEventListener('livewire:load', () => {
    //     Livewire.on('alert', () => {
    //         setTimeout(() => {
    //             // Cache les messages flash après 5 secondes
    //             document.querySelector('.alert-danger, .alert-success').style.display = 'none';
    //         }, 5000);
    //     });
    // });
    
})

// Attendre que Livewire charge entièrement la page
document.addEventListener('livewire:load', function () {
        alert('');
});
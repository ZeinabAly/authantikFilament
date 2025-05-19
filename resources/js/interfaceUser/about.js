document.addEventListener('DOMContentLoaded', function(){
    var listItems = document.querySelectorAll('.productByCategory .list-item') ;
    listItems.forEach(item => {
        item.classList.add('list-item-active');
            listItems.forEach(items => {
                item.addEventListener('click', function(){
            });
            item.classList.remove('list-item-active');
            
        })
    });

    document.addEventListener('livewire:load', () => {
        console.log('Livewire est chargé');
    });
    
    
})

document.addEventListener('livewire:load', function(){
    alert('');
})

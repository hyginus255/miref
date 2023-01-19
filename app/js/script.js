const btnMenu = document.querySelector('#btn_menu');
btnMenu.addEventListener('click', function(){
    console.log("open menu");

    if(btnMenu.classList.contains('open')){
        btnMenu.classList.remove('open');
    }else{
        btnMenu.classList.add('open');
    }
    
});
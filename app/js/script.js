const btnMenu = document.querySelector('#btn_menu');
btnMenu.addEventListener('click', function(){
    // console.log("open menu");

    if(btnMenu.classList.contains('open')){
        btnMenu.classList.remove('open');
    }else{
        btnMenu.classList.add('open');
    }
    
});

const faqText = document.querySelector('.faq__text');
const faqClose = document.querySelector('.faq__close');
const faqOpen = document.querySelector('.faq__open');

faqClose.addEventListener('click',function(){
    faqText.style.display = "none";
    faqOpen.style.display = "block";
    faqClose.style.display = "none";
});

faqOpen.addEventListener('click',function(){
    faqText.style.display = "block";
    faqOpen.style.display = "none";
    faqClose.style.display = "block";
});
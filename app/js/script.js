// Header Navigation
const btnMenu = document.querySelector('#btn_menu');
const background = document.querySelector('.background');


btnMenu.addEventListener('click', function(){
    
    console.log(background);

    if(btnMenu.classList.contains('open')){
        btnMenu.classList.remove('open');
        background.style.display = "none";
        document.body.style.overflow = "visible";
        
    }else{
        btnMenu.classList.add('open');
        background.style.display = "block";
        document.body.style.overflow = "hidden";
    }
    
});






//FAQ

// const faqText = document.querySelector('.faq__text');
// const faqClose = document.querySelector('.faq__close');
// const faqOpen = document.querySelector('.faq__open');

// faqClose.addEventListener('click',function(){
//     faqText.style.display = "none";
//     faqOpen.style.display = "block";
//     faqClose.style.display = "none";
// });

// faqOpen.addEventListener('click',function(){
//     faqText.style.display = "block";
//     faqOpen.style.display = "none";
//     faqClose.style.display = "block";
// });
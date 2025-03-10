let navbar = document.querySelector('#header')

document.addEventListener("scroll", ()=>{
    let scrollTop = window.scrollY

    if(scrollTop > 0){
        navbar.classList.add('rolar')
    } else{
        navbar.classList.remove('rolar')
    }

})
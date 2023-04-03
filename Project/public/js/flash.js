/*
* INCLUDE FLASH AVANT REQUEST
*/

// permite to create a flash
function createFlash(type, response) {
    const closeButton = document.querySelector('.closebtn')
    const alert = document.querySelector('.flash')
    const message = alert.querySelector('.message')

    // add the css and the content to the flash
    alert.classList.add(type)
    message.textContent = response
    alert.style.display = 'block'

    closeButton.addEventListener('click', () => closeFlash(alert, type, message))

    const tl = gsap.timeline({ paused: true });

    // animation pour afficher le message
    // -100% pour le faire descendre de au dessus du top jusqu'a 0% du top puis display block
    tl.fromTo(alert, { top: "-100px" }, { top: 0, display: "block", duration: 0.5 });

    // animation pour masquer le message
    // on remonte le flash au dessus du top puis display none après 3s 
    tl.to(alert, { top: "-100px", display: "none", duration: 0.5, delay: 3 });

    tl.add(() => closeFlash(alert, type, message))

    // pour jouer l'animation
    tl.play();
}

// permite to close a flash
function closeFlash(alert, type, message) {
    alert.classList.remove(type)
    alert.style.display = "none";
}

const btnPermanentTicketing = document.querySelector(".ticketing-permanent-button")
const btnLimitedTicketing = document.querySelector(".ticketing-limited-button")
const buttons = document.querySelectorAll(".li-ticketing")
const ticketingPermanentDiv = document.querySelector(".div-ticketing-permanent")
const ticketingLimitedDiv = document.querySelector(".div-ticketing-limited")

const showTicketingPermanent = (title = null) => {
    ticketingPermanentDiv.style.display = 'block'
    ticketingLimitedDiv.style.display = 'none'

    // si il faut changer le titre de la partie (backoffice)
    if (title) {
        title.innerText = 'Les offres permanentes'
    }
}

const showTicketingLimited = (title = null) => {
    ticketingPermanentDiv.style.display = 'none'
    ticketingLimitedDiv.style.display = 'block'

    // si il faut changer le titre de la partie (backoffice)
    if (title) {
        title.innerText = 'Les offres limitées'
    }
}

const handleClick = (e) => {

    // Récupération du nouveau bouton cliquer
    ticketingUnderline = document.querySelector(".ticketing-underline")

    // Récupération de l'ancien bouton cliquer, de sa taille en largeur et de sa position left
    previous = document.querySelector(".li-ticketing-active")
    previous.style.width = document.querySelector(".li-ticketing-active").offsetWidth + "px"
    previous.style.left = document.querySelector(".li-ticketing-active").offsetLeft + "px"

    // On enlève la classe li-ticketing-active de l'ancien bouton cliquer
    previous.classList.remove("li-ticketing-active")

    // On donne la classe li-ticketing-active au nouveau bouton cliquer
    e.target.classList.add("li-ticketing-active")

    // On récupère pour l'underline, la taille en largeur et la position left du nouveau bouton cliquer
    ticketingUnderline.style.width = document.querySelector(".li-ticketing-active").offsetWidth + "px"
    ticketingUnderline.style.left = document.querySelector(".li-ticketing-active").offsetLeft + "px"

    // Création d'une timeline et paused sur true pour pas que ça se lance des le load de la page
    const timeline = gsap.timeline({ paused: true });

    // Slide de l'underline de l'ancien bouton au nouveau
    timeline.fromTo(ticketingUnderline, { width: previous.style.width, left: previous.style.left }, { width: ticketingUnderline.style.width, left: ticketingUnderline.style.left, duration: 0.5 });

    // On joue la timeline
    timeline.play();
}

ticketingLimitedDiv.style.display = 'none'

let title = null
if (document.querySelector('#backoffice-ticketing')) {
    title = document.querySelector('.title-ticketing')
}

btnPermanentTicketing.addEventListener('click', () => showTicketingPermanent(title))
btnLimitedTicketing.addEventListener('click', () => showTicketingLimited(title))

buttons.forEach(btn => {
    btn.addEventListener('click', handleClick)
});

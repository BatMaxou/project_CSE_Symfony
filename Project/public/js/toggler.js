//initialisé la hauteur du menu burger
const nav = document.querySelector(".navbar-responsive")
nav.style.height = window.innerHeight + "px"

//animation au click du bouton toggle
const button = document.querySelector("#navbar-toggler")
const line1 = document.querySelector(".line-toggler:nth-child(1)")
const line2 = document.querySelector(".line-toggler:nth-child(2)")
const line3 = document.querySelector(".line-toggler:nth-child(3)")

var togglerIsDefault = "true"

button.addEventListener("click", handleClickToggler)

function handleClickToggler() {
    if (togglerIsDefault == "true") {
        togglerIsDefault = "undifined"
        line2.animate({ width: '90%', left: '50%' }, { duration: 200, iterations: 1, fill: 'forwards' })
        line3.animate({ width: '90%', left: '50%' }, { duration: 200, iterations: 1, fill: 'forwards' })
        nav.animate({ left: '0' }, { duration: 400, iterations: 1, fill: 'forwards' })
        setTimeout(() => {
            line1.animate({ top: '50%', transform: 'translate(-50%,-50%) rotate(45deg)' }, { duration: 200, iterations: 1, fill: 'forwards' })
            line3.animate({ top: '50%', transform: 'translate(-50%,-50%) rotate(-45deg)' }, { duration: 200, iterations: 1, fill: 'forwards' })
            line2.animate({ opacity: '0' }, { duration: 200, iterations: 1, fill: 'forwards' })
            togglerIsDefault = "false"
        }, 199)

    }
    else if (togglerIsDefault == "false") {
        togglerIsDefault = "undifined"
        line1.animate({ top: '25%', transform: 'translate(-50%,-25%) rotate(0deg)' }, { duration: 200, iterations: 1, fill: 'forwards' })
        line3.animate({ top: '75%', transform: 'translate(-50%,-75%) rotate(0deg)' }, { duration: 200, iterations: 1, fill: 'forwards' })
        nav.animate({ left: '-250px' }, { duration: 400, iterations: 1, fill: 'forwards' })
        setTimeout(() => {
            line2.animate({ opacity: '1' }, { duration: 200, iterations: 1, fill: 'forwards' })
            setTimeout(() => {
                line2.animate({ width: '75%', left: '42.5%' }, { duration: 200, iterations: 1, fill: 'forwards' })
                line3.animate({ width: '60%', left: '35%' }, { duration: 200, iterations: 1, fill: 'forwards' })
                togglerIsDefault = "true"
            }, 199)
        }, 150)
    }
}
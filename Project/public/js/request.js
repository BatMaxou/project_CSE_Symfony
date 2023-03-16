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
    tl.fromTo(alert, { y: "-100%" }, { y: "0%", display: "block", duration: 0.5 });

    // animation pour masquer le message
    // on remonte le flash au dessus du top puis display none après 3s 
    tl.to(alert, { y: "-100%", display: "none", duration: 0.5, delay: 3 });

    // pour jouer l'animation
    tl.play();
}

// permite to close a flash
function closeFlash(alert, type, message) {
    alert.classList.remove(type)
    alert.style.display = "none";
    tl.play();
}

// newsletter inscription request
const inscriptionSubmit = document.querySelector('#footer .inscription input[type="submit"]')
const inscriptionInput = document.querySelector('#footer .inscription input[type="text"]')
const consentInput = document.querySelector('#footer .inscription input[type="checkbox"]')
const inscriptionError = document.querySelector('#footer .inscription .input-error')

const handleInscriptionClick = (e) => {
    e.preventDefault()
    const request = prepareRequest()

    request.onreadystatechange = () => {
        // inscriptionError.textContent = request.response
        if (request.status === 200) {
            consentInput.checked = false
            inscriptionInput.value = ''
            createFlash('alert-success', request.response)
        } else {
            createFlash('alert-error', request.response)
        }
    }
    request.send('newsletter=true&mail=' + inscriptionInput.value + '&consent=' + consentInput.checked)
}

inscriptionSubmit.addEventListener('click', handleInscriptionClick)

// survey user response request
const surveySubmit = document.querySelector('.sidebar-survey button[type="submit"]')
const surveyInputs = document.querySelectorAll('.sidebar-survey input[type="radio"]')

const handleSurveyClick = (e) => {
    e.preventDefault()
    let selected = null

    surveyInputs.forEach(input => {
        if (input.checked) {
            selected = input
        }
    })

    if (selected.value) {
        const request = prepareRequest()

        request.onreadystatechange = () => {
            if (request.status === 200) {
                selected.checked = false
                createFlash('alert-success', request.response)
            } else {
                createFlash('alert-error', request.response)
            }
        }

        request.send('survey=true&response=' + selected.value)
    } else {
        createFlash('alert-error', 'Veuillez choisir une option.')
    }
}

surveySubmit.addEventListener('click', handleSurveyClick)
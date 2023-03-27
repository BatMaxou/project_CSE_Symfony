// permite to create a flash
function createFlash(type, response) {
    const closeButton = document.querySelector('.closebtn')
    const alert = document.querySelector('.flash')
    const message = alert.querySelector('.message')

    // add the css and the content to the flash
    alert.classList.add(type)
    message.textContent = response
    alert.style.display = 'block'

    closeButton.addEventListener('click', () => closeFlash(alert, type))

    const tl = gsap.timeline({ paused: true });

    // animation pour afficher le message
    // -100% pour le faire descendre de au dessus du top jusqu'a 0% du top puis display block
    tl.fromTo(alert, { y: "-100%" }, { y: "0%", display: "block", duration: 0.5 });

    // animation pour masquer le message
    // on remonte le flash au dessus du top puis display none après 3s 
    tl.to(alert, { y: "-100%", display: "none", duration: 0.5, delay: 3 });

    tl.add(() => closeFlash(alert, type))

    // pour jouer l'animation
    tl.play();
}

// permite to close a flash
function closeFlash(alert, type) {
    alert.classList.remove(type)
    alert.style.display = "none";
}

// newsletter inscription request
const inscriptionForm = document.querySelector('#footer .inscription form')
if (inscriptionForm) {
    const inscriptionInput = document.querySelector('#footer .inscription input[type="text"]')
    const consentInput = document.querySelector('#footer .inscription input[type="checkbox"]')

    const handleInscriptionSubmit = async (e) => {
        e.preventDefault()

        const response = await fetch(inscriptionForm.getAttribute('action'), {
            method: inscriptionForm.getAttribute('method'),
            body: new FormData(e.target)
        })

        const msg = await response.text()

        if (response.status === 200) {
            consentInput.checked = false
            inscriptionInput.value = ''
            createFlash('alert-success', msg)
        } else {
            createFlash('alert-error', msg)
        }
    }

    inscriptionForm.addEventListener('submit', handleInscriptionSubmit)
}

// survey user response request
const surveyForm = document.querySelector('.sidebar-survey form')
if (surveyForm) {
    const surveyInputs = document.querySelectorAll('.sidebar-survey input[type="radio"]')

    const handleSurveySubmit = async (e) => {
        e.preventDefault()

        let selected = { value: null }

        surveyInputs.forEach(input => {
            if (input.checked) {
                selected = input
            }
        })

        if (selected.value) {
            const response = await fetch(surveyForm.getAttribute('action'), {
                method: surveyForm.getAttribute('method'),
                body: new FormData(e.target)
            })

            const msg = await response.text()

            if (response.status === 200) {
                selected.checked = false
                createFlash('alert-success', msg)
            } else {
                createFlash('alert-error', msg)
            }
        } else {
            createFlash('alert-error', 'Veuillez choisir une option.')
        }
    }

    surveyForm.addEventListener('submit', handleSurveySubmit)
}

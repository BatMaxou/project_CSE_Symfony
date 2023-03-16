// permite to create a flash
function createFlash(type, response) {
    const closeButton = document.querySelector('.sidebar-survey .closebtn')
    const alert = document.querySelector('.sidebar-survey .flash')
    const message = alert.querySelector('.message')

    // add the css and the content to the flash
    alert.classList.add(type)
    alert.style.display = 'block'
    message.textContent = response

    closeButton.addEventListener('click', () => closeFlash(alert, type, message))

    // made the disaparition of the flash
    setTimeout(() => {
        if (alert) {
            closeFlash(alert, type, message)
        }
    }, 4000)
}

// permite to close a flash
function closeFlash(alert, type, message) {
    alert.classList.remove(type)
    message.textContent = ''
    alert.style.display = 'none'
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
        inscriptionError.textContent = request.response
        if (request.status === 200) {
            consentInput.checked = false
            inscriptionInput.value = ''
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
    let response = null

    surveyInputs.forEach(input => {
        if (input.checked) {
            response = input.value
        }
    })

    if (response) {
        const request = prepareRequest()

        request.onreadystatechange = () => {
            if (request.status === 200) {
                createFlash('alert-success', request.response)
            } else {
                createFlash('alert-error', request.response)
            }
        }

        request.send('survey=true&response=' + response)
    } else {
        createFlash('alert-error', 'Veuillez choisir une option.')
    }
}

surveySubmit.addEventListener('click', handleSurveyClick)
// newsletter inscription request
const inscriptionForm = document.querySelector('#footer .inscription form')
if (inscriptionForm) {
    const inscriptionInput = document.querySelector('#footer .inscription input[type="email"]')
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

const contactForm = document.querySelector('#contact form')

if (contactForm) {
    const name = document.querySelector('#contact_name')
    const firstname = document.querySelector('#contact_firstname')
    const message = document.querySelector('#contact_message')
    const email = document.querySelector('#contact_email')
    const checkbox = document.querySelectorAll('#contact form input[type="checkbox"]')

    const handleContactSubmit = async (e) => {
        e.preventDefault()

        const response = await fetch(e.target.getAttribute('action'), {
            method: e.target.getAttribute('method'),
            body: new FormData(e.target)
        })

        const msg = await response.text()

        if (response.status === 200) {
            name.value = ""
            firstname.value = ""
            message.value = ""
            email.value = ""
            checkbox.forEach((el) => {
                el.checked = false
            })

            createFlash('alert-success', msg)
        } else {
            createFlash('alert-error', msg)
        }
    }

    contactForm.addEventListener('submit', handleContactSubmit)
}

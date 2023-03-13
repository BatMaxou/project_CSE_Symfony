const inscriptionSubmit = document.querySelector('#footer .inscription input[type="submit"]')
const inscriptionInput = document.querySelector('#footer .inscription input[type="text"]')
const consentInput = document.querySelector('#footer .inscription input[type="checkbox"]')
const inscriptionError = document.querySelector('#footer .inscription .input-error')

const handleInscriptionClick = (e) => {
    e.preventDefault()
    const request = new XMLHttpRequest()

    request.onreadystatechange = () => {
        inscriptionError.textContent = request.response
        if (request.status === 200) {
            consentInput.checked = false
            inscriptionInput.value = ''
        }
    }

    request.open("POST", "https://127.0.0.1:8000/post")
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
    request.send('mail=' + inscriptionInput.value + '&consent=' + consentInput.checked)
}

inscriptionSubmit.addEventListener('click', handleInscriptionClick)
const inscriptionSubmit = document.querySelector('#footer .inscription input[type="submit"]')
const inscriptionInput = document.querySelector('#footer .inscription input[type="text"]')
const inscriptionError = document.querySelector('#footer .inscription .input-error')

const handleInscriptionClick = (e) => {
    e.preventDefault()
    const request = new XMLHttpRequest()

    request.onreadystatechange = () => {
        if (request.status === 200) {
            inscriptionError.textContent = request.response
        }
    }

    request.open("POST", "https://127.0.0.1:8000/post")
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
    request.send('mail=' + inscriptionInput.value)

}

inscriptionSubmit.addEventListener('click', handleInscriptionClick)
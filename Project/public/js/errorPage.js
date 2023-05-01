// handle le margin selon la taille de la navbar
const navbar = document.querySelector('#navbar')
const cardError = document.querySelector('#error-page')

cardError.style.marginTop = navbar.clientHeight + 50 + 'px'

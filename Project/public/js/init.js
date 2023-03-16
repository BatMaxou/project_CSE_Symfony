const width = window.innerWidth
const height = window.innerHeight

// permite to prepare a request to the RequestController
function prepareRequest() {
    const request = new XMLHttpRequest()

    request.open("POST", "https://127.0.0.1:8000/post")
    // A tester si problème d'accès
    // request.open("POST", "http://127.0.0.1:8000/post")
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')

    return request
}
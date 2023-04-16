const addResponseSurveyBtn = document.querySelector('.add-response')
const responses = document.querySelector('.responses ul')
let ttResponse = 2

const handleAddResponse = () => {
    // nb réponse +1
    ttResponse++

    // Si il y a 7 réponses, on ne peut en rajouter plus
    if (ttResponse === 7) {
        gsap.to(addResponseSurveyBtn, {
            opacity: 0,
            height: '0px',
            paddingTop: '0px',
            paddingBottom: '0px',
            duration: 0.5,
        }).then(() => addResponseSurveyBtn.style.display = 'none')
    }

    // création de l'élément HTML
    const newResponse = document.createElement('div')
    newResponse.classList.add('response')
    newResponse.innerHTML =
        '<input type="text" id="survey_response_' + ttResponse + '" name="survey[response_' + ttResponse + ']" required="required" placeholder="Réponse ' + ttResponse + '" class="form-input">' +
        '<span>' +
        '<img src="/images/Delete.svg" alt="icône de poubelle">' +
        '</span>'

    // création de l'élément <li> et remplissage avec l'élément réponse
    const newLi = document.createElement('li');
    newLi.appendChild(newResponse)
    responses.appendChild(newLi)

    // gestion de la suppression de la réponse
    const deleteResponseIcon = newResponse.querySelector('img')
    deleteResponseIcon.addEventListener('click', () => handleDeleteResponse(newLi))

    // animations d'apparition
    gsap.from(newLi, {
        opacity: 0,
        duration: 0.5,
    })
    gsap.from(newResponse, {
        height: '0px',
        paddingBottom: '0px',
        duration: 0.5
    })
}

const handleDeleteResponse = (el) => {
    // nbReponse -1
    ttResponse--

    // si l'on repasse à 6 réponse après une suppression, alors on affiche le btn d'ajout
    if (ttResponse === 6) {
        gsap.to(addResponseSurveyBtn, {
            display: 'block',
            opacity: 1,
            height: 'auto',
            paddingTop: '5px',
            paddingBottom: '5px',
            duration: 0.5,
        })
    }

    // disparition de la réponse
    gsap.to(el.querySelector('.response'), {
        height: '0px',
        paddingBottom: '0px',
        duration: 0.5,
    })

    gsap.to(el, {
        opacity: 0,
        height: '0px',
        duration: 0.5,
    }).then(() => {
        const idSup = el.querySelector('input').id.split('_')[2]
        el.remove()
        // changer le numéro des réponses suivantes
        elements = responses.querySelectorAll('li .response')
        elements.forEach((element, index) => {
            if (index + 1 >= idSup) {
                const input = element.querySelector('input')
                input.id = 'survey_response_' + (index + 1)
                input.placeholder = 'Réponse ' + (index + 1)
                input.name = 'survey[response_' + (index + 1) + ']'
            }
        });
    })
}

addResponseSurveyBtn.addEventListener('click', handleAddResponse)
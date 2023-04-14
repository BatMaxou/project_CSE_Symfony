// Survey request

// si un GET est précisé et qu'il correspond à 'new=true', alors effectuer l'animation d'ajout et clear le GET
let getParameter = null

if ((getParameter = window.location.href.split('?')[1])
    && (getParameter = getParameter.split('='))
    && (getParameter[0] === 'new')
    && (getParameter[1] === 'true')) {
    // passer outre la 'card' d'ajout
    // cards est recup dans cardAnimation.js
    // transform cards de nodelist a array 
    handleAddCard(Array.from(cards), true)
    window.history.replaceState({}, document.title, window.location.pathname);
}

// gestion CRUD
// afficher le modal concerné
const handleSurveysDisplayModal = (e, index, type, btnSubmit, form) => {
    e.preventDefault()

    if (type === 'edit') {

        // Récupération de form de modification
        const formData = new FormData(form)

        // Traitement de l'affichage des données modifiées dans la modal
        const editDesactivate = document.querySelector('.modal .edit-survey-question')

        // Affichage des champs
        editDesactivate.innerHTML = '- Désactivation du sondage : ' + '<b>' + formData.get('survey[question]') + '</b>'

        // Fin du traitement de l'affichage 

        btnSubmit.addEventListener('click', () => handleSurveysSubmit(index, formData, form, type), { once: true })
    }
    else if (type === 'delete') {
        // Récupération du form pour le delete
        const formData = new FormData(form)

        // Traitement de l'affichage des données modifiées dans la modal
        const deleteQuestion = document.querySelector('.modal .delete-survey-question')

        // Affichage du champ
        deleteQuestion.innerHTML = '- Sondage : <b>' + formData.get('survey[question]') + '</b>'

        // Fin du traitement de l'affichage 

        // Button et action de suppression des members
        btnSubmit.addEventListener('click', () => handleSurveysSubmit(index, formData, form, type), { once: true })
    }
    else if (type === 'add') {

        // Récupération de form de modification
        const formData = new FormData(form)

        // Traitement de l'affichage des données modifiées dans la modal
        const addQuestion = document.querySelector('.modal .add-survey-question')
        const addResponses = document.querySelector('.modal .add-survey-responses')
        const nbResponses = form.querySelectorAll('.response').length

        // Affichage des champs
        addQuestion.innerHTML = '- Sondage : ' + '<b>' + formData.get('survey[question]') + '</b>'
        addResponses.innerHTML = '- Réponses : '

        for (let index = 1; index <= nbResponses; index++) {
            addResponses.innerHTML += '<p class="add-survey-response">- <b>' + formData.get('survey[response_' + index + ']') + '</b></p>'
        }

        // Fin du traitement de l'affichage

        btnSubmit.addEventListener('click', () => handleSurveysSubmit(index, formData, form, type), { once: true })
    }
}

// gérer la requête en ajax
const handleSurveysSubmit = async (index, formData, form, type) => {

    let response = null

    if (type === 'edit') {
        response = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: formData
        })

        closeModal(document.querySelector('.modal-background-edit'))
    }
    else if (type === 'delete') {
        response = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: formData
        })

        closeModal(document.querySelector('.modal-background-delete'))
    }
    else if (type === 'add') {
        response = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: formData
        })

        closeModal(document.querySelector('.modal-background-add'))
    }

    const msg = await response.text()

    if (response.status === 200) {
        if (type === 'edit') {
            // Card animation
            handleBtnEditDesactivateSurvey(index)
            const cardFooter = document.createElement('div')
            cardFooter.classList.add('card-footer')
            cardFooter.innerHTML =
                '<p>Recharger la page afin de pouvoir supprimer ce sondage</p>'
            cards[index].appendChild(cardFooter)
        }
        else if (type === 'delete') {
            // Card animation
            // 'cards' est défini dans cardAnimation.js
            handleBtnDelete(index, Array.from(cards))
        }
        else if (type === 'add') {
            setTimeout(() => {
                window.location.replace(window.location.href + '?new=true')
            }, 1000);
        }
        createFlash('alert-success', msg)
    } else {
        createFlash('alert-error', msg)
    }
}

// btn declencheurs
const deleteSurveyBtns = document.querySelectorAll('#backoffice-survey .modal-open-delete')

// formulaires
const addSurveyForm = document.querySelector('#backoffice-survey .add-form')
const editSurveyForm = document.querySelector('#backoffice-survey .edit-form')
const deleteSurveyForms = document.querySelectorAll('#backoffice-survey .delete-form')

// form
let btnAdd = document.querySelector('.modal-background-add .btn-add')
addSurveyForm.addEventListener('submit', (e) => handleSurveysDisplayModal(e, 0, 'add', btnAdd, e.target))

if (deleteSurveyForms.length != 0) {

    let btnDelete = document.querySelector('.modal-background-delete .btn-delete')

    deleteSurveyBtns.forEach((btn, index) => {
        btn.addEventListener('click', (e) => handleSurveysDisplayModal(e, index, 'delete', btnDelete, deleteSurveyForms[index]))
    })
}

if (editSurveyForm) {

    let btnEdit = document.querySelector('.modal-background-edit .btn-edit')

    const desactivateBtn = document.querySelector('#backoffice-survey .modal-open-edit')
    desactivateBtn.addEventListener('click', (e) => handleSurveysDisplayModal(e, 1, 'edit', btnEdit, editSurveyForm))
}

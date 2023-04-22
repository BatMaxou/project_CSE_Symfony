// Survey request

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

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSurveySubmit(index, formData, form, type, 0), { once: true }
        }

        // ajout de l'event à chaque affichage du modal 
        btnSubmit.addEventListener('click', submit, { once: true })

        // récupérer les éléments pemettant la fermeture du modal
        const modalClose = modalBackgroundEdit.querySelector('.modal-close')
        const btnClose = modalBackgroundEdit.querySelector('.btn-close')

        // enlever l'event du btnSubmit lorsqu'il existe pour éviter les doublons
        modalClose.addEventListener('click', () => {
            btnSubmit.removeEventListener('click', submit, { once: true })
        })
        btnClose.addEventListener('click', () => {
            btnSubmit.removeEventListener('click', submit, { once: true })
        });

        // pour fermer lorsqu'on clique en dehors du modal  
        modalBackgroundEdit.addEventListener('click', (event) => {
            if (event.target == modalBackgroundEdit) {
                btnSubmit.removeEventListener('click', submit, { once: true })
            }
        })
    }
    else if (type === 'delete') {
        // Récupération du form pour le delete
        const formData = new FormData(form)

        // Traitement de l'affichage des données modifiées dans la modal
        const deleteQuestion = document.querySelector('.modal .delete-survey-question')

        // Affichage du champ
        deleteQuestion.innerHTML = '- Sondage : <b>' + formData.get('survey[question]') + '</b>'

        // Fin du traitement de l'affichage 

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSurveySubmit(index, formData, form, type, 0), { once: true }
        }

        // ajout de l'event à chaque affichage du modal 
        btnSubmit.addEventListener('click', submit, { once: true })

        // récupérer les éléments pemettant la fermeture du modal
        const modalClose = modalBackgroundDelete.querySelector('.modal-close')
        const btnClose = modalBackgroundDelete.querySelector('.btn-close')

        // enlever l'event du btnSubmit lorsqu'il existe pour éviter les doublons
        modalClose.addEventListener('click', () => {
            btnSubmit.removeEventListener('click', submit, { once: true })
        })
        btnClose.addEventListener('click', () => {
            btnSubmit.removeEventListener('click', submit, { once: true })
        });

        // pour fermer lorsqu'on clique en dehors du modal  
        modalBackgroundDelete.addEventListener('click', (event) => {
            if (event.target == modalBackgroundDelete) {
                btnSubmit.removeEventListener('click', submit, { once: true })
            }
        })
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

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSurveySubmit(index, formData, form, type, 0), { once: true }
        }

        // ajout de l'event à chaque affichage du modal 
        btnSubmit.addEventListener('click', submit, { once: true })

        // récupérer les éléments pemettant la fermeture du modal
        const modalClose = modalBackgroundAdd.querySelector('.modal-close')
        const btnClose = modalBackgroundAdd.querySelector('.btn-close')

        // enlever l'event du btnSubmit lorsqu'il existe pour éviter les doublons
        modalClose.addEventListener('click', () => {
            btnSubmit.removeEventListener('click', submit, { once: true })
        })
        btnClose.addEventListener('click', () => {
            btnSubmit.removeEventListener('click', submit, { once: true })
        });

        // pour fermer lorsqu'on clique en dehors du modal  
        modalBackgroundAdd.addEventListener('click', (event) => {
            if (event.target == modalBackgroundAdd) {
                btnSubmit.removeEventListener('click', submit, { once: true })
            }
        })
    }
}

// gérer la requête en ajax
const handleSurveySubmit = async (index, formData, form, type) => {

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
        createFlash('alert-success', msg, 0.5)
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
const btnAdd = document.querySelector('.modal-background-add .btn-add')
addSurveyForm.addEventListener('submit', (e) => handleSurveysDisplayModal(e, 0, 'add', btnAdd, e.target))

if (deleteSurveyForms.length !== 0) {
    const btnDelete = document.querySelector('.modal-background-delete .btn-delete')

    deleteSurveyBtns.forEach((btn, index) => {
        btn.addEventListener('click', (e) => handleSurveysDisplayModal(e, index, 'delete', btnDelete, deleteSurveyForms[index]))
    })
}

if (editSurveyForm) {
    const btnEdit = document.querySelector('.modal-background-edit .btn-edit')

    const desactivateBtn = document.querySelector('#backoffice-survey .modal-open-edit')
    desactivateBtn.addEventListener('click', (e) => handleSurveysDisplayModal(e, 1, 'edit', btnEdit, editSurveyForm))
}

// Partnership request

// choix de l'image
const labelFileAdd = document.querySelector('.add-partnership .card .card-image label')
const partnerImgAdd = document.querySelector('.add-partnership .card .card-image img')
const labelsFile = document.querySelectorAll('.partnerships .card .card-image label')
const memberImgs = document.querySelectorAll('.partnerships .card .card-image img')

const handleChangeImageClick = (e, type, index = null) => {
    e.preventDefault()
    let inputfile = null
    if (type === 'add') {
        inputfile = document.querySelector('.add-partnership .card input[type=file]')
    } else if (type === 'edit') {
        inputfile = document.querySelector('.partnerships .card:nth-child(' + (index + 1) + ') input[type=file]')
    }
    inputfile.click()
}

labelFileAdd.addEventListener('click', (e) => handleChangeImageClick(e, 'add'))

partnerImgAdd.addEventListener('click', (e) => handleChangeImageClick(e, 'add'))

labelsFile.forEach((label, index) => {
    label.addEventListener('click', (e) => handleChangeImageClick(e, 'edit', index))
})

memberImgs.forEach((img, index) => {
    img.addEventListener('click', (e) => handleChangeImageClick(e, 'edit', index))
})

// gestion CRUD
// afficher le modal concerné
const handlePartnershipsDisplayModal = (e, index, type, btnSubmit, form) => {
    e.preventDefault()

    if (type === 'edit') {

        // Récupération de form de modification
        const formData = new FormData(form)

        // Traitement de l'affichage des données modifiées dans la modal
        const editName = document.querySelector('.modal .edit-partnership-name')
        const editDescription = document.querySelector('.modal .edit-partnership-description')
        const editLink = document.querySelector('.modal .edit-partnership-link')
        const editImg = document.querySelector('.modal .edit-partnership-image')

        // Affichage des champs
        editName.innerHTML = '- Nouveau nom du partenaire : ' + '<b>' + formData.get('partnership[name]') + '</b>'
        editDescription.innerHTML = '- Nouvelle description du partenaire : ' + '<b>' + formData.get('partnership[description]') + '</b>'
        editLink.innerHTML = '- Nouveau lien du site du partenaire : ' + '<b>' + formData.get('partnership[link]') + '</b>'

        if (formData.get('partnership[image]').name === '') {
            editImg.innerHTML = '- <b> Pas de nouvelle photo </b>'
        } else {
            editImg.innerHTML = '- Nouvelle photo du partenaire : ' + '<b>' + formData.get('partnership[image]').name + '</b>'
        }

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSubmit(index, formData, form, type), { once: true }
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
        const deleteName = document.querySelector('.modal .delete-partnership-name')

        // Affichage du champ
        deleteName.innerHTML = 'Nom du partenaire : <b>' + formData.get('partnership[name]') + '</b>'

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSubmit(index, formData, form, type), { once: true }
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
        const addName = document.querySelector('.modal .add-partnership-name')
        const addDescription = document.querySelector('.modal .add-partnership-description')
        const addLink = document.querySelector('.modal .add-partnership-link')
        const addImg = document.querySelector('.modal .add-partnership-image')

        // Affichage des champs
        addName.innerHTML = '- Prénom : ' + '<b>' + formData.get('partnership[name]') + '</b>'
        addDescription.innerHTML = '- Nom : ' + '<b>' + formData.get('partnership[description]') + '</b>'
        addLink.innerHTML = '- fonction : ' + '<b>' + formData.get('partnership[link]') + '</b>'

        if (formData.get('partnership[image]').name === '') {
            addImg.innerHTML = '- <b> Pas photo du partenaire </b>'
        } else {
            addImg.innerHTML = '- Photo du partenaire : ' + '<b>' + formData.get('partnership[image]').name + '</b>'
        }

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSubmit(index, formData, form, type), { once: true }
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

// btn declencheurs
const editPartnershipBtns = document.querySelectorAll('#backoffice-partnership .modal-open-edit')
const deletePartnershipBtns = document.querySelectorAll('#backoffice-partnership .modal-open-delete')

// formulaires
const addPartnershipForm = document.querySelector('#backoffice-partnership .add-form')
const editPartnershipForm = document.querySelectorAll('#backoffice-partnership .edit-form')
const deletePartnershipForm = document.querySelectorAll('#backoffice-partnership .delete-form')

// form
const btnAdd = document.querySelector('.modal-background-add .btn-add')
addPartnershipForm.addEventListener('submit', (e) => handlePartnershipsDisplayModal(e, 0, 'add', btnAdd, e.target))

if (editPartnershipForm.length !== 0 && deletePartnershipForm.length !== 0) {

    let btnEdit = document.querySelector('.modal-background-edit .btn-edit')
    let btnDelete = document.querySelector('.modal-background-delete .btn-delete')

    // btn
    editPartnershipBtns.forEach((btn, index) => {
        btn.addEventListener('click', (e) => handlePartnershipsDisplayModal(e, index, 'edit', btnEdit, editPartnershipForm[index]))
    });
    deletePartnershipBtns.forEach((btn, index) => {
        btn.addEventListener('click', (e) => handlePartnershipsDisplayModal(e, index, 'delete', btnDelete, deletePartnershipForm[index]))
    });
}

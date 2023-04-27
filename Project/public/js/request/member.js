// Member request

// choix de l'image
const labelFileAdd = document.querySelector('.add-member .card .card-image label')
const memberImgAdd = document.querySelector('.add-member .card .card-image img')
const labelsFile = document.querySelectorAll('.members .card .card-image label')
const memberImgs = document.querySelectorAll('.members .card .card-image img')

const handleChangeImageClick = (e, type, index = null) => {
    e.preventDefault()
    let inputfile = null
    if (type === 'add') {
        inputfile = document.querySelector('.add-member .card input[type=file]')
    } else if (type === 'edit') {
        inputfile = document.querySelector('.members .card:nth-child(' + (index + 1) + ') input[type=file]')
    }
    inputfile.click()
}

labelFileAdd.addEventListener('click', (e) => handleChangeImageClick(e, 'add'))

memberImgAdd.addEventListener('click', (e) => handleChangeImageClick(e, 'add'))

labelsFile.forEach((label, index) => {
    label.addEventListener('click', (e) => handleChangeImageClick(e, 'edit', index))
})

memberImgs.forEach((img, index) => {
    img.addEventListener('click', (e) => handleChangeImageClick(e, 'edit', index))
})

// gestion CRUD
// afficher le modal concerné
const handleMembersDisplayModal = (e, index, type, btnSubmit, form) => {
    e.preventDefault()

    if (type === 'edit') {

        // Récupération de form de modification
        const formData = new FormData(form)

        // Traitement de l'affichage des données modifiées dans la modal
        const editFirstName = document.querySelector('.modal .edit-member-first-name')
        const editLastName = document.querySelector('.modal .edit-member-last-name')
        const editFunction = document.querySelector('.modal .edit-member-function')
        const editImg = document.querySelector('.modal .edit-member-profil')

        // Affichage des champs
        editFirstName.innerHTML = '- Nouveau Prénom : ' + '<b>' + formData.get('member[firstName]') + '</b>'
        editLastName.innerHTML = '- Nouveau Nom : ' + '<b>' + formData.get('member[lastName]') + '</b>'
        editFunction.innerHTML = '- Nouvelle fonction : ' + '<b>' + formData.get('member[function]') + '</b>'

        if (formData.get('member[profil]').name === '') {
            editImg.innerHTML = '- <b> Pas de nouvelle photo de profil </b>'
        } else {
            editImg.innerHTML = '- Nouvelle photo de profil : ' + '<b>' + formData.get('member[profil]').name + '</b>'
        }

        // Fin du traitement de l'affichage 

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSubmit(index, formData, form, type, 0), { once: true }
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
        const deleteFullName = document.querySelector('.modal .delete-member-full-name')

        // Affichage du champ
        deleteFullName.innerHTML = '- Membre : <b>' + formData.get('member[firstName]') + ' ' + formData.get('member[lastName]') + '</b>'

        // Fin du traitement de l'affichage 

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSubmit(index, formData, form, type, {member: true}), { once: true }
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
        const addFirstName = document.querySelector('.modal .add-member-first-name')
        const addLastName = document.querySelector('.modal .add-member-last-name')
        const addFunction = document.querySelector('.modal .add-member-function')
        const addImg = document.querySelector('.modal .add-member-profil')

        // Affichage des champs
        addFirstName.innerHTML = '- Prénom : ' + '<b>' + formData.get('member[firstName]') + '</b>'
        addLastName.innerHTML = '- Nom : ' + '<b>' + formData.get('member[lastName]') + '</b>'
        addFunction.innerHTML = '- fonction : ' + '<b>' + formData.get('member[function]') + '</b>'

        if (formData.get('member[profil]').name === '') {
            addImg.innerHTML = '- <b> Pas photo de profil </b>'
        } else {
            addImg.innerHTML = '- Photo de profil : ' + '<b>' + formData.get('member[profil]').name + '</b>'
        }

        // Fin du traitement de l'affichage

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSubmit(index, formData, form, type, 0, {member: true}), { once: true }
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
const editMemberBtns = document.querySelectorAll('#backoffice-member .modal-open-edit')
const deleteMemberBtns = document.querySelectorAll('#backoffice-member .modal-open-delete')

// formulaires
const addMemberForm = document.querySelector('#backoffice-member .add-form')
const editMemberForms = document.querySelectorAll('#backoffice-member .edit-form')
const deleteMemberForms = document.querySelectorAll('#backoffice-member .delete-form')

// form
const btnAdd = document.querySelector('.modal-background-add .btn-add')
addMemberForm.addEventListener('submit', (e) => handleMembersDisplayModal(e, 0, 'add', btnAdd, e.target))

if (editMemberForms.length !== 0 && deleteMemberForms.length !== 0) {

    let btnEdit = document.querySelector('.modal-background-edit .btn-edit')
    let btnDelete = document.querySelector('.modal-background-delete .btn-delete')

    // btn
    editMemberBtns.forEach((btn, index) => {
        btn.addEventListener('click', (e) => handleMembersDisplayModal(e, index, 'edit', btnEdit, editMemberForms[index]))
    });
    deleteMemberBtns.forEach((btn, index) => {
        btn.addEventListener('click', (e) => handleMembersDisplayModal(e, index, 'delete', btnDelete, deleteMemberForms[index]))
    });
}

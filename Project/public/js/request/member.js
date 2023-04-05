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

// btn declencheurs
const editMemberBtns = document.querySelectorAll('#backoffice-member .btn-save')
const deleteMemberBtns = document.querySelectorAll('#backoffice-member .btn-delete')

// formulaires
const addMemberForm = document.querySelector('#backoffice-member .add-form')
const editMemberForms = document.querySelectorAll('#backoffice-member .edit-form')
const deleteMemberForms = document.querySelectorAll('#backoffice-member .delete-form')

if (editMemberBtns.length != 0 && deleteMemberBtns.length != 0) {

    let btnEdit = document.querySelector('.modal-background-edit .btn-edit')
    let btnDelete = document.querySelector('.modal-background-delete .btn-delete')
    let btnAdd = document.querySelector('.modal-background-add .btn-add')

    const handleMembersDisplayModal = (e, index, type) => {
        e.preventDefault()

        console.log(type);

        if (type === 'edit') {

            // Récupération de form de modification
            form = new FormData(editMemberForms[index])

            // Traitement de l'affichage des données modifiées dans la modal
            const editFirstName = document.querySelector('.modal .edit-member-first-name')
            const editLastName = document.querySelector('.modal .edit-member-last-name')
            const editFunction = document.querySelector('.modal .edit-member-function')
            const editImg = document.querySelector('.modal .edit-member-profil')

            // Affichage des champs
            editFirstName.innerHTML = 'Nouveau Prénom : ' + form.get('member[firstName]')
            editLastName.innerHTML = 'Nouveau Nom : ' + form.get('member[lastName]')
            editFunction.innerHTML = 'Nouvelle fonction : ' + form.get('member[function]')

            if (form.get('member[profil]').name === '') {
                editImg.innerHTML = 'Pas de nouvelle photo de profil'
            } else {
                editImg.innerHTML = 'Nouvelle photo de profil : ' + form.get('member[profil]').name
            }

            // Fin du traitement de l'affichage 

            btnEdit.addEventListener('click', () => handleMembersSubmit(index, form, type), { once: true })
        }
        else if (type === 'delete') {
            // Récupération du form pour le delete
            form = new FormData(deleteMemberBtns[index])

            // Traitement de l'affichage des données modifiées dans la modal
            let emailValue = document.querySelectorAll('#member_form_email')
            const deleteEmail = document.querySelector('.delete-member-email')
            deleteEmail.innerHTML = emailValue[index + 1].value

            // Fin du traitement de l'affichage 

            // Button et action de suppression des members
            btnDelete.addEventListener('click', () => handleMembersSubmit(index, form, type), { once: true })
        }
        else if (type === 'add') {

            // Récupération de form de modification
            form = new FormData(addMemberForm)

            // Traitement de l'affichage des données modifiées dans la modal
            const addFirstName = document.querySelector('.modal .add-member-first-name')
            const addLastName = document.querySelector('.modal .add-member-last-name')
            const addFunction = document.querySelector('.modal .add-member-function')
            const addImg = document.querySelector('.modal .add-member-profil')

            if (form.get('member[profil]').name === '') {
                addImg.innerHTML = 'Pas photo de profil'
            } else {
                addImg.innerHTML = 'Photo de profil : ' + form.get('member[profil]').name
            }


            // Affichage des champs
            addFirstName.innerHTML = 'Nouveau Prénom : ' + form.get('member[firstName]')
            addLastName.innerHTML = 'Nouveau Nom : ' + form.get('member[lastName]')
            addFunction.innerHTML = 'Nouvelle fonction : ' + form.get('member[function]')

            // Fin du traitement de l'affichage

            btnAdd.addEventListener('click', () => handleMembersSubmit(index, form, type), { once: true })
        }
    }

    const handleMembersSubmit = async (index, form, type) => {

        let response = null

        if (type === 'edit') {
            console.log('okok');

            response = await fetch(editMemberForms[index].getAttribute('action'), {
                method: editMemberForms[index].getAttribute('method'),
                body: form
            })

            closeModal(document.querySelector('.modal-background-edit'))
        }
        else if (type === 'delete') {
            response = await fetch(deleteMemberForms[index].getAttribute('action'), {
                method: deleteMemberForms[index].getAttribute('method'),
                body: form
            })

            closeModal(document.querySelector('.modal-background-delete'))
        }
        else if (type === 'add') {
            response = await fetch(addMemberForm.getAttribute('action'), {
                method: addMemberForm.getAttribute('method'),
                body: form
            })

            closeModal(document.querySelector('.modal-background-add'))
        }

        const msg = await response.text()

        if (response.status === 200) {
            if (type === 'edit') {
                // Card animation
                handleBtnEdit(index + 1)
            }
            else if (type === 'delete') {
                // Card animation
                handleBtnDelete(index + 1)
            }
            createFlash('alert-success', msg)
        } else {
            createFlash('alert-error', msg)
        }
    }

    // btn
    editMemberBtns.forEach((btn, index) => {
        btn.addEventListener('click', (e) => handleMembersDisplayModal(e, index, 'edit'))
    });
    deleteMemberBtns.forEach((btn, index) => {
        btn.addEventListener('click', (e) => handleMembersDisplayModal(e, index, 'delete'))
    });
    // form
    addMemberForm.addEventListener('submit', (e) => handleMembersDisplayModal(e, 0, 'add'))
}

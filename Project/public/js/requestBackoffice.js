// Admin request
const addAdminForm = document.querySelector('#backoffice-admin .add-form')
const editAdminForms = document.querySelectorAll('#backoffice-admin .edit-form')
const deleteAdminForms = document.querySelectorAll('#backoffice-admin .delete-form')

if (editAdminForms.length != 0 && deleteAdminForms.length != 0) {

    let btnEdit = document.querySelector('.modal .btn-edit')
    let btnDelete = document.querySelector('.modal .btn-delete')

    const handleAdminsDisplayModal = (e, index, type) => {
        e.preventDefault()

        if (type === 'edit') {

            // Récupération de form de modification
            form = new FormData(editAdminForms[index])

            // Traitement de l'affichage des données modifiées dans la modal
            const editEmail = document.querySelector('.edit-admin-email')
            const editPassword = document.querySelector('.edit-admin-password')
            const editRoles = document.querySelector('.edit-admin-roles')

            // Masque des caractères du mot de passe
            let newPassword = ''
            for (let i = 0; i < form.get('admin_form[plainPassword]').length; i++) {
                newPassword = newPassword + '*'
            }
            if (newPassword === '') {
                editPassword.innerHTML = 'Nouveau mot de passe : Aucun nouveau mot de passe ';
            }
            else {
                editPassword.innerHTML = 'Nouveau mot de passe : ' + newPassword;
            }

            // Affichage de l'email
            editEmail.innerHTML = 'Nouveau e-mail : ' + form.get('admin_form[email]')

            // Affichage des roles
            if (form.get('admin_form[roles]') == 1) {
                editRoles.innerHTML = 'Nouveau rôle : admin';
            }
            if (form.get('admin_form[roles]') == 2) {
                editRoles.innerHTML = 'Rôle : Super admin';
            }
            // Fin du traitement de l'affichage 

            btnEdit.addEventListener('click', () => handleAdminsSubmit(index, form, type), { once: true })
        }
        else if (type === 'delete') {
            // Récupération du form pour le delete
            form = new FormData(deleteAdminForms[index])

            // Traitement de l'affichage des données modifiées dans la modal
            let emailValue = document.querySelectorAll('#admin_form_email')
            const deleteEmail = document.querySelector('.delete-admin-email')
            deleteEmail.innerHTML = emailValue[index + 1].value

            console.log(document.querySelector('#admin_form_email').value);
            // Fin du traitement de l'affichage 

            // Button et action de suppression des admins
            btnDelete.addEventListener('click', () => handleAdminsSubmit(index, form, type), { once: true })
        }
        else if (type === 'add') {

            console.log(index)

            // Récupération de form de modification
            form = new FormData(addAdminForms)

            // Traitement de l'affichage des données modifiées dans la modal
            const addEmail = document.querySelector('.add-admin-email')
            const addPassword = document.querySelector('.add-admin-password')
            const addRoles = document.querySelector('.add-admin-roles')

            // Masque des caractères du mot de passe
            let newPassword = ''
            for (let i = 0; i < form.get('admin_form[plainPassword]').length; i++) {
                newPassword = newPassword + '*'
            }
            addPassword.innerHTML = 'Mot de passe : ' + newPassword;

            // Affichage de l'email
            addEmail.innerHTML = 'E-mail : ' + form.get('admin_form[email]')

            // Affichage des roles
            if (form.get('admin_form[roles]') == 1) {
                addRoles.innerHTML = 'Rôle : admin';
            }
            if (form.get('admin_form[roles]') == 2) {
                addRoles.innerHTML = 'Rôle : Super admin';
            }
            // Fin du traitement de l'affichage 

            btnAdd.addEventListener('click', () => handleAdminsSubmit(index, form, type), { once: true })
        }
    }

    const handleAdminsSubmit = async (index, form, type) => {

        let response = null

        if (type === 'edit') {
            response = await fetch(editAdminForms[index].getAttribute('action'), {
                method: editAdminForms[index].getAttribute('method'),
                body: form
            })

            closeModal(document.querySelector('.modal-background-edit'))
        }
        else if (type === 'delete') {
            response = await fetch(deleteAdminForms[index].getAttribute('action'), {
                method: deleteAdminForms[index].getAttribute('method'),
                body: form
            })

            closeModal(document.querySelector('.modal-background-delete'))

            // Card animation
            handleBtnDelete(index)
        }
        else if (type === 'add') {
            response = await fetch(addAdminForm.getAttribute('action'), {
                method: addAdminForm.getAttribute('method'),
                body: form
            })

            closeModal(document.querySelector('.modal-background-add'))
        }

        const msg = await response.text()

        if (response.status === 200) {
            createFlash('alert-success', msg)
        } else {
            createFlash('alert-error', msg)
        }
    }

    editAdminForms.forEach((element, index) => {
        element.addEventListener('submit', (e) => handleAdminsDisplayModal(e, index, 'edit'))
    });
    deleteAdminForms.forEach((element, index) => {
        element.addEventListener('submit', (e) => handleAdminsDisplayModal(e, index, 'delete'))
    });
    addAdminForm.addEventListener('submit', (e) => handleAdminsDisplayModal(e, 0, 'add'))
}

// ckeditor request
const textsForm = document.querySelector('#texts form')
if (textsForm) {
    const handleTextsSubmit = async (e) => {
        e.preventDefault()

        const response = await fetch(e.target.getAttribute('action'), {
            method: e.target.getAttribute('method'),
            body: new FormData(e.target)
        })

        const msg = await response.text()

        if (response.status === 200) {
            createFlash('alert-success', msg)
        } else {
            createFlash('alert-error', msg)
        }
    }


    textsForm.addEventListener('submit', handleTextsSubmit)
}

// request pour update partenariat dans backoffice
const partnerEditForm = document.querySelectorAll('#backoffice-partnership form')

if (partnerEditForm.length !== 0) {

    const handlePartnerEditSubmit = async (e) => {
        e.preventDefault()

        const response = await fetch(e.target.getAttribute('action'), {
            method: e.target.getAttribute('method'),
            body: new FormData(e.target)
        })

        const msg = await response.text()

        if (response.status === 200) {

            createFlash('alert-success', msg)
        } else {
            createFlash('alert-error', msg)
        }
    }

    partnerEditForm.forEach(form => {
        form.addEventListener('submit', (e) => handlePartnerEditSubmit(e))
    });

    const partnerDelete = document.querySelectorAll('#backoffice-partnership .btn-delete')

    partnerDelete.forEach(el => {
        const btnDelete = el.dataset.id
        el.addEventListener('click', (e) => deletePartnership(e))
    })

    const deletePartnership = async (e) => {
        e.preventDefault()

        console.log(e.target.dataset.id);

        const response = await fetch(e.target.getAttribute('action'), {
            method: e.target.getAttribute('method'),
            body: new FormData(e.target)
        })

        const msg = await response.text()

        if (response.status === 200) {

            createFlash('alert-success', msg)
        } else {
            createFlash('alert-error', msg)
        }
    }
}
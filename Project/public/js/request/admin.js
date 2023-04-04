// Admin request
const addAdminForm = document.querySelector('#backoffice-admin .add-form')
const editAdminForms = document.querySelectorAll('#backoffice-admin .edit-form')
const deleteAdminForms = document.querySelectorAll('#backoffice-admin .delete-form')

if (editAdminForms.length != 0 && deleteAdminForms.length != 0) {

    let btnEdit = document.querySelector('.modal-background-edit .btn-edit')
    let btnDelete = document.querySelector('.modal-background-delete .btn-delete')
    let btnAdd = document.querySelector('.modal-background-add .btn-add')

    const handleAdminsDisplayModal = (e, index, type) => {
        e.preventDefault()

        if (type === 'edit') {

            // Récupération de form de modification
            form = new FormData(editAdminForms[index])

            // Traitement de l'affichage des données modifiées dans la modal
            const editEmail = document.querySelector('.edit-admin-email')
            const editPassword = document.querySelector('.edit-admin-password')
            const editRole = document.querySelector('.edit-admin-role')

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
                editRole.innerHTML = 'Nouveau rôle : admin';
            }
            if (form.get('admin_form[roles]') == 2) {
                editRole.innerHTML = 'Rôle : Super admin';
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

            // Fin du traitement de l'affichage 

            // Button et action de suppression des admins
            btnDelete.addEventListener('click', () => handleAdminsSubmit(index, form, type), { once: true })
        }
        else if (type === 'add') {

            // Récupération de form de modification
            form = new FormData(addAdminForm)

            // Traitement de l'affichage des données modifiées dans la modal
            const addEmail = document.querySelector('.add-admin-email')
            const addPassword = document.querySelector('.add-admin-password')
            const addRole = document.querySelector('.add-admin-role')

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
                addRole.innerHTML = 'Rôle : admin';
            }
            if (form.get('admin_form[roles]') == 2) {
                addRole.innerHTML = 'Rôle : Super admin';
            }
            // Fin du traitement de l'affichage 

            btnAdd.addEventListener('click', () => handleAdminsSubmit(index, form, type), { once: true })
        }
    }

    const handleAdminsSubmit = async (index, form, type) => {
        console.log('okokok');

        let response = null

        if (type === 'edit') {
            console.log('okok');

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

    editAdminForms.forEach((element, index) => {
        element.addEventListener('submit', (e) => handleAdminsDisplayModal(e, index, 'edit'))
    });
    deleteAdminForms.forEach((element, index) => {
        element.addEventListener('submit', (e) => handleAdminsDisplayModal(e, index, 'delete'))
    });
    addAdminForm.addEventListener('submit', (e) => handleAdminsDisplayModal(e, 0, 'add'))
}

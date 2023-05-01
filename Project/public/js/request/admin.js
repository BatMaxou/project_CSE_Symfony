// Admin request

const handleAdminsDisplayModal = (e, index, type, btnSubmit) => {
    e.preventDefault()

    if (type === 'edit') {

        // Récupération de form de modification
        const formData = new FormData(editAdminForms[index])

        // Traitement de l'affichage des données modifiées dans la modal
        const editEmail = document.querySelector('.edit-admin-email')
        const editPassword = document.querySelector('.edit-admin-password')
        const editRole = document.querySelector('.edit-admin-role')

        // Masque des caractères du mot de passe
        let newPassword = ''
        for (let i = 0; i < formData.get('admin[plainPassword]').length; i++) {
            newPassword = newPassword + '*'
        }
        if (newPassword === '') {
            editPassword.innerHTML = 'Nouveau mot de passe : <b>Aucun nouveau mot de passe</b>';
        }
        else {
            editPassword.innerHTML = 'Nouveau mot de passe : ' + '<b>' + newPassword + '</b>';
        }

        // Affichage de l'email
        editEmail.innerHTML = 'Nouveau e-mail : ' + '<b>' + formData.get('admin[email]') + '</b>'

        // Affichage des roles
        if (formData.get('admin[roles]') == 1) {
            editRole.innerHTML = 'Nouveau rôle : <b>admin</b>';
        }
        if (formData.get('admin[roles]') == 2) {
            editRole.innerHTML = 'Rôle : <b>Super admin</b>';
        }
        // Fin du traitement de l'affichage 

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSubmit(index, formData, e.target, type), { once: true }
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
        const formData = new FormData(deleteAdminForms[index])

        // Traitement de l'affichage des données modifiées dans la modal
        const emailValue = formData.get('admin[email]')
        const deleteEmail = document.querySelector('.delete-admin-email')
        deleteEmail.innerHTML = '<b>' + emailValue + '</b>'

        // Fin du traitement de l'affichage 

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSubmit(index, formData, e.target, type, { deleteSelfAdmin: true }), { once: true }
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
        const formData = new FormData(addAdminForm)

        // Traitement de l'affichage des données modifiées dans la modal
        const addEmail = document.querySelector('.add-admin-email')
        const addPassword = document.querySelector('.add-admin-password')
        const addRole = document.querySelector('.add-admin-role')

        // Masque des caractères du mot de passe
        let newPassword = ''
        for (let i = 0; i < formData.get('admin[plainPassword]').length; i++) {
            newPassword = newPassword + '*'
        }
        addPassword.innerHTML = 'Mot de passe : ' + '<b>' + newPassword + '</b>';

        // Affichage de l'email
        addEmail.innerHTML = 'E-mail : ' + '<b>' + formData.get('admin[email]') + '</b>'

        // Affichage des roles
        if (formData.get('admin[roles]') == 1) {
            addRole.innerHTML = 'Rôle : <b>admin</b>';
        }
        if (formData.get('admin[roles]') == 2) {
            addRole.innerHTML = 'Rôle : <b>Super admin</b>';
        }
        // Fin du traitement de l'affichage 

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSubmit(index, formData, e.target, type), { once: true }
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

const addAdminForm = document.querySelector('#backoffice-admin .add-form')
const editAdminForms = document.querySelectorAll('#backoffice-admin .edit-form')
const deleteAdminForms = document.querySelectorAll('#backoffice-admin .delete-form')

const btnEdit = document.querySelector('.modal-background-edit .btn-edit')
const btnDelete = document.querySelector('.modal-background-delete .btn-delete')
const btnAdd = document.querySelector('.modal-background-add .btn-add')

addAdminForm.addEventListener('submit', (e) => handleAdminsDisplayModal(e, 0, 'add', btnAdd))

if (editAdminForms.length !== 0 && deleteAdminForms.length !== 0) {
    editAdminForms.forEach((element, index) => {
        element.addEventListener('submit', (e) => handleAdminsDisplayModal(e, index, 'edit', btnEdit))
    });
    deleteAdminForms.forEach((element, index) => {
        element.addEventListener('submit', (e) => handleAdminsDisplayModal(e, index, 'delete', btnDelete))
    });
}

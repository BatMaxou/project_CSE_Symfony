// permite to create a flash
function createFlash(type, response) {
    const closeButton = document.querySelector('.closebtn')
    const alert = document.querySelector('.flash')
    const message = alert.querySelector('.message')

    // add the css and the content to the flash
    alert.classList.add(type)
    message.textContent = response
    alert.style.display = 'block'

    closeButton.addEventListener('click', () => closeFlash(alert, type, message))

    const tl = gsap.timeline({ paused: true });

    // animation pour afficher le message
    // -100% pour le faire descendre de au dessus du top jusqu'a 0% du top puis display block
    tl.fromTo(alert, { y: "-100%" }, { y: "0%", display: "block", duration: 0.5 });

    // animation pour masquer le message
    // on remonte le flash au dessus du top puis display none après 3s 
    tl.to(alert, { y: "-100%", display: "none", duration: 0.5, delay: 3 });

    tl.add(() => closeFlash(alert, type, message))

    // pour jouer l'animation
    tl.play();
}

// permite to close a flash
function closeFlash(alert, type) {
    alert.classList.remove(type)
    alert.style.display = "none";
}

// Admin request
const editAdminForms = document.querySelectorAll('#backoffice-admin .edit-form')
const deleteAdminForms = document.querySelectorAll('#backoffice-admin .delete-form')

if (editAdminForms.length != 0 && deleteAdminForms.length != 0) {

    let btnEdit = document.querySelector('.modal .btn-edit')
    let btnDelete = document.querySelector('.modal .btn-delete')

    const handleAdminsDisplayModal = (e, index, type) => {
        e.preventDefault()

        if (type === 'edit') {

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

            editEmail.innerHTML = 'Nouveau e-mail : ' + form.get('admin_form[email]')

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
            form = new FormData(deleteAdminForms[index])

            console.log(deleteAdminForms[index]);

            // Traitement de l'affichage des données modifiées dans la modal
            const deleteEmail = document.querySelector('.delete-admin-email')

            console.log(form.get('admin_form[id]'));

            deleteEmail.innerHTML = form.get('admin_form[email]')
            // Fin du traitement de l'affichage 

            btnDelete.addEventListener('click', () => handleAdminsSubmit(index, form, type), { once: true })
        }
        else if (type === 'add') {
            // Traitement de l'affichage des données modifiées dans la modal
            const editEmail = document.querySelector('.info-admin-email')

            editEmail.innerHTML = form.get('admin_form[email]')
            // Fin du traitement de l'affichage 

            btnEdit.addEventListener('click', () => handleEditAdminsSubmit(index, form, type), { once: true })
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
        }
        else if (type === 'add') {
            response = await fetch(addAdminForms[index].getAttribute('action'), {
                method: addAdminForms[index].getAttribute('method'),
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

const contactForm = document.querySelector('#backoffice-message form')

if (contactForm) {
    const message = document.querySelector('#contact_message')

    const handleContactSubmit = async (e) => {
        e.preventDefault()

        const response = await fetch(e.target.getAttribute('action'), {
            method: e.target.getAttribute('method'),
            body: new FormData(e.target)
        })

        const msg = await response.text()

        if (response.status === 200) {
            message.value = ""

            createFlash('alert-success', msg)
        } else {
            createFlash('alert-error', msg)
        }
    }

    contactForm.addEventListener('submit', handleContactSubmit)
}

// afficher le modal concerné
const handlePartnershipsDisplayModal = (e, index, type, btnSubmit, form) => {
    e.preventDefault()

    if (type === 'delete') {
        // Récupération du form pour le delete
        const formData = new FormData(form)

        // Traitement de l'affichage des données modifiées dans la modal
        const deleteMessage = document.querySelector('.modal .delete-message')

        // Affichage du champ
        deleteMessage.innerHTML = 'Mail du message : <b>' + formData.get('contact[email]') + '</b>'

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSubmit(index, formData, form, type, { message: true }), { once: true }
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
}

// btn declencheurs
const deleteMessageBtn = document.querySelectorAll('#backoffice-messages .modal-open-delete')

// formulaires
const deleteMessageForm = document.querySelectorAll('#backoffice-messages .delete-form')

if (deleteMessageForm.length !== 0) {

    let btnDelete = document.querySelector('.modal-background-delete .btn-delete')

    deleteMessageBtn.forEach((btn, index) => {
        btn.addEventListener('click', (e) => handlePartnershipsDisplayModal(e, index, 'delete', btnDelete, deleteMessageForm[index]))
    });
}

// const pour l'animation js permanent/limitée add
const typeTicketing = document.querySelector(".add-offer #ticketing_type")
const numberMinPlaceTicketing = document.querySelector("#backoffice-ticketing .number-min")
const orderNumberTicketing = document.querySelector("#backoffice-ticketing .order-number")

const onChangeTicketingAdd = () => {
    if (typeTicketing.value === '1') {
        orderNumberTicketing.style.display = 'block'
        numberMinPlaceTicketing.style.display = 'none'
        numberMinPlaceTicketing.querySelector('input').value = ''
    }
    else if (typeTicketing.value === '0') {
        orderNumberTicketing.style.display = 'none'
        numberMinPlaceTicketing.style.display = 'block'
        orderNumberTicketing.querySelector('select').value = 0
    }
}

orderNumberTicketing.style.display = 'none'
typeTicketing.addEventListener('change', onChangeTicketingAdd)

// Ticketing request

// btn declencheurs
const editTicketingBtns = document.querySelectorAll('#backoffice-ticketing .modal-open-edit')
const deleteTicketingBtns = document.querySelectorAll('#backoffice-ticketing .modal-open-delete')

// formulaires
const addTicketingForm = document.querySelector('#backoffice-ticketing .add-form')
const editTicketingForms = document.querySelectorAll('#backoffice-ticketing .edit-form')
const deleteTicketingForms = document.querySelectorAll('#backoffice-ticketing .delete-form')


// choix des images

const labelFileAdds = document.querySelectorAll('.add-offer .card .card-image label')
const ticketingImgAdds = document.querySelectorAll('.add-offer .card .card-image img')
const permanentLabelsFile = document.querySelectorAll('.offers .div-ticketing-permanent .card .card-image label')
const permanentOfferImgs = document.querySelectorAll('.offers .div-ticketing-permanent .card .card-image img')
const limitedLabelsFile = document.querySelectorAll('.offers .div-ticketing-limited .card .card-image label')
const limitedOfferImgs = document.querySelectorAll('.offers .div-ticketing-limited .card .card-image img')

const handleChangeImageClick = (e, type, nbImage, offerType = null, index = null) => {
    e.preventDefault()
    let inputfiles = []
    let inputfile = null
    if (type === 'add') {
        inputfiles = document.querySelectorAll('.add-offer .card input[type=file]')
        inputfile = inputfiles[nbImage]
    }
    else if (type === 'edit') {
        inputfiles = document.querySelectorAll('.offers .div-ticketing-' + offerType + ' .card:nth-child(' + (index) + ') input[type=file]')
        inputfile = inputfiles[nbImage]
    }
    inputfile.click()
}

labelFileAdds.forEach((labelFileAdd, nbImage) => {
    labelFileAdd.addEventListener('click', (e) => handleChangeImageClick(e, 'add', nbImage))
});

ticketingImgAdds.forEach((ticketingImgAdd, nbImage) => {
    ticketingImgAdd.addEventListener('click', (e) => handleChangeImageClick(e, 'add', nbImage))
});

permanentLabelsFile.forEach((label, index) => {
    const nbImage = (index % 4)
    const nbCard = ~~(index / 4) + 1
    label.addEventListener('click', (e) => handleChangeImageClick(e, 'edit', nbImage, 'permanent', nbCard))
})

permanentOfferImgs.forEach((img, index) => {
    const nbImage = (index % 4)
    const nbCard = ~~(index / 4) + 1
    img.addEventListener('click', (e) => handleChangeImageClick(e, 'edit', nbImage, 'permanent', nbCard))
})

limitedLabelsFile.forEach((label, index) => {
    const nbImage = (index % 4)
    const nbCard = ~~(index / 4) + 1
    label.addEventListener('click', (e) => handleChangeImageClick(e, 'edit', nbImage, 'limited', nbCard))
})

limitedOfferImgs.forEach((img, index) => {
    const nbImage = (index % 4)
    const nbCard = ~~(index / 4) + 1
    img.addEventListener('click', (e) => handleChangeImageClick(e, 'edit', nbImage, 'limited', nbCard))
})

// gestion CRUD
// afficher le modal concerné
const handleTicketingsDisplayModal = (e, index, type, btnSubmit, form) => {
    e.preventDefault()

    if (type === 'edit') {

        // Récupération de form de modification
        const formData = new FormData(form)

        // Traitement de l'affichage des données modifiées dans la modal
        const editName = document.querySelector('.modal .edit-offer-name')
        const editText = document.querySelector('.modal .edit-offer-text')
        const editDateStart = document.querySelector('.modal .edit-offer-date-start')
        const editDateEnd = document.querySelector('.modal .edit-offer-date-end')

        const editPartnership = document.querySelector('.modal .edit-offer-partnership')
        const editNumberMin = document.querySelector('.modal .edit-offer-number-min')
        const editOrderNumber = document.querySelector('.modal .edit-offer-order-number')

        const editImage1 = document.querySelector('.modal .edit-offer-image-1')
        const editImage2 = document.querySelector('.modal .edit-offer-image-2')
        const editImage3 = document.querySelector('.modal .edit-offer-image-3')
        const editImage4 = document.querySelector('.modal .edit-offer-image-4')

        // Affichage des champs
        editName.innerHTML = '- Nom : <b>' + formData.get('ticketing[name]') + '</b>'
        editText.innerHTML = '- Text : <b>' + formData.get('ticketing[text]') + '</b>'
        editDateStart.innerHTML = '- Date de début : <b>' + formData.get('ticketing[date_start]') + '</b>'
        editDateEnd.innerHTML = '- Date de fin : <b>' + formData.get('ticketing[date_end]') + '</b>'

        if (formData.get('ticketing[partnership]') === '') {
            editPartnership.innerHTML = '- Partenaire associé : <b> Aucun partenaire renseigné </b>'
        } else {
            editPartnership.innerHTML = '- Partenaire associé : <b>' + form.querySelector('#ticketing_partnership option:nth-child(' + (parseInt(formData.get('ticketing[partnership]')) + 1) + ')').innerText + '</b>'
        }

        if (formData.get('ticketing[type]') === '0') {
            if (formData.get('ticketing[number_min_place]') === '0') {
                editNumberMin.innerHTML = '- Place nécessaire minimum : <b> 0 </b>'
            } else {
                editNumberMin.innerHTML = '- Place nécessaire minimum : <b>' + formData.get('ticketing[number_min_place]') + '</b>'
            }
        }

        if (formData.get('ticketing[type]') === '1') {
            if (formData.get('ticketing[order_number]') === '0') {
                editOrderNumber.innerHTML = '- Ordre d\'affichage : <b> Ne pas apparaître </b>'
            } else {
                editOrderNumber.innerHTML = '- Ordre d\'affichage : <b>' + formData.get('ticketing[order_number]') + '</b>'
            }
        }

        if (formData.get('ticketing[image1]').name === '') {
            editImage1.innerHTML = '- <b> Pas de nouvelle première image </b>'
        } else {
            editImage1.innerHTML = '- Image 1 : <b>' + formData.get('ticketing[image1]').name + '</b>'
        }

        if (formData.get('ticketing[image2]').name === '') {
            editImage2.innerHTML = '- <b> Pas de nouvelle deuxième image </b>'
        } else {
            editImage2.innerHTML = '- Image 2 : <b>' + formData.get('ticketing[image2]').name + '</b>'
        }

        if (formData.get('ticketing[image3]').name === '') {
            editImage3.innerHTML = '- <b> Pas de nouvelle troisième image </b>'
        } else {
            editImage3.innerHTML = '- Image 3 : <b>' + formData.get('ticketing[image3]').name + '</b>'
        }

        if (formData.get('ticketing[image4]').name === '') {
            editImage4.innerHTML = '- <b> Pas de nouvelle quatrième image </b>'
        } else {
            editImage4.innerHTML = '- Image 4 : <b>' + formData.get('ticketing[image4]').name + '</b>'
        }

        // Fin du traitement de l'affichage

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
        // Récupération de form de modification
        const formData = new FormData(form)

        // Traitement de l'affichage des données modifiées dans la modal
        const editName = document.querySelector('.modal .delete-offer-name')

        // Affichage des champs

        editName.innerHTML = '- Nom : <b>' + formData.get('ticketing[name]') + '</b>'

        // Fin du traitement de l'affichage

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
    else if (type === 'add') {

        // Récupération de form de modification
        const formData = new FormData(form)

        // Traitement de l'affichage des données modifiées dans la modal
        const addType = document.querySelector('.modal .add-offer-type')
        const addName = document.querySelector('.modal .add-offer-name')
        const addText = document.querySelector('.modal .add-offer-text')
        const addDateStart = document.querySelector('.modal .add-offer-date-start')
        const addDateEnd = document.querySelector('.modal .add-offer-date-end')

        const addPartnership = document.querySelector('.modal .add-offer-partnership')
        const addNumberMin = document.querySelector('.modal .add-offer-number-min')
        const addOrderNumber = document.querySelector('.modal .add-offer-order-number')

        const addImage1 = document.querySelector('.modal .add-offer-image-1')
        const addImage2 = document.querySelector('.modal .add-offer-image-2')
        const addImage3 = document.querySelector('.modal .add-offer-image-3')
        const addImage4 = document.querySelector('.modal .add-offer-image-4')

        let offerType = null

        // Affichage des champs
        if (formData.get('ticketing[type]') === '0') {
            addType.innerHTML = '- Type de l\'offre : <b>Permanente</b>'
            offerType = 'permanent'
        } else {
            addType.innerHTML = '- Type de l\'offre : <b>Limitée</b>'
            offerType = 'limited'
        }

        addName.innerHTML = '- Nom : <b>' + formData.get('ticketing[name]') + '</b>'
        addText.innerHTML = '- Text : <b>' + formData.get('ticketing[text]') + '</b>'
        addDateStart.innerHTML = '- Date de début : <b>' + formData.get('ticketing[date_start]') + '</b>'
        addDateEnd.innerHTML = '- Date de fin : <b>' + formData.get('ticketing[date_end]') + '</b>'
        addImage1.innerHTML = '- Image 1 : <b>' + formData.get('ticketing[image1]').name + '</b>'

        if (formData.get('ticketing[partnership]') === '') {
            addPartnership.innerHTML = '- Partenaire associé : <b> Aucun partenaire renseigné </b>'
        } else {
            addPartnership.innerHTML = '- Partenaire associé : <b>' + form.querySelector('#ticketing_partnership option:nth-child(' + (parseInt(formData.get('ticketing[partnership]')) + 1) + ')').innerText + '</b>'
        }

        if (formData.get('ticketing[type]') === '0') {
            if (formData.get('ticketing[number_min_place]')) {
                addNumberMin.innerHTML = '- Place nécessaire minimum : <b>' + formData.get('ticketing[number_min_place]') + '</b>'
            } else {
                addNumberMin.innerHTML = '- Place nécessaire minimum : <b> 0 </b>'
            }
        }

        if (formData.get('ticketing[type]') === '1') {
            if (formData.get('ticketing[order_number]')) {
                addOrderNumber.innerHTML = '- Ordre d\'affichage : <b>' + formData.get('ticketing[order_number]') + '</b>'
            } else {
                addOrderNumber.innerHTML = '- Ordre d\'affichage : <b> Ne pas apparaître </b>'
            }
        }

        if (formData.get('ticketing[image2]').name === '') {
            addImage2.innerHTML = '- <b> Pas de deuxième image </b>'
        } else {
            addImage2.innerHTML = '- Image 2 : <b>' + formData.get('ticketing[image2]').name + '</b>'
        }

        if (formData.get('ticketing[image3]').name === '') {
            addImage3.innerHTML = '- <b> Pas de troisième image </b>'
        } else {
            addImage3.innerHTML = '- Image 3 : <b>' + formData.get('ticketing[image3]').name + '</b>'
        }

        if (formData.get('ticketing[image4]').name === '') {
            addImage4.innerHTML = '- <b> Pas de quatrième image </b>'
        } else {
            addImage4.innerHTML = '- Image 4 : <b>' + formData.get('ticketing[image4]').name + '</b>'
        }

        // Fin du traitement de l'affichage

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSubmit(index, formData, form, type, { addOffer: offerType }), { once: true }
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

// form
let btnAdd = document.querySelector('.modal-background-add .btn-add')
addTicketingForm.addEventListener('submit', (e) => handleTicketingsDisplayModal(e, 0, 'add', btnAdd, e.target))

if (editTicketingForms.length != 0 && deleteTicketingForms.length != 0) {

    let btnEdit = document.querySelector('.modal-background-edit .btn-edit')
    let btnDelete = document.querySelector('.modal-background-delete .btn-delete')

    // btn
    editTicketingBtns.forEach((btn, index) => {
        btn.addEventListener('click', (e) => handleTicketingsDisplayModal(e, index, 'edit', btnEdit, editTicketingForms[index]))
    });
    deleteTicketingBtns.forEach((btn, index) => {
        btn.addEventListener('click', (e) => handleTicketingsDisplayModal(e, index, 'delete', btnDelete, deleteTicketingForms[index]))
    });
}

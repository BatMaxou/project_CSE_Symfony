// const pour l'animation js permanent/limitée modif
const btnAllTicketing = document.querySelector(".ticketing-all-button")
const btnPermanentTicketing = document.querySelector(".ticketing-permanent-button")
const btnLimitedTicketing = document.querySelector(".ticketing-limited-button")
const buttons = document.querySelectorAll(".li-ticketing")
const ticketingPermanentDivs = document.querySelectorAll(".card-permanent")
const ticketingLimitedDivs = document.querySelectorAll(".card-limited")

// const pour l'animation js permanent/limitée add
const typeTicketing = document.querySelector(".add-ticketing #ticketing_type")
const orderNumberTicketing = document.querySelector("#backoffice-ticketing .number-min")
const numberMinPlaceTicketing = document.querySelector("#backoffice-ticketing .order-number")

// btn declencheurs
const editTicketingBtns = document.querySelectorAll('#backoffice-ticketing .modal-open-edit')
const deleteTicketingBtns = document.querySelectorAll('#backoffice-ticketing .modal-open-delete')

// formulaires
const addTicketingForm = document.querySelector('#backoffice-ticketing .add-form')
const editTicketingForms = document.querySelectorAll('#backoffice-ticketing .edit-form')
const deleteTicketingForms = document.querySelectorAll('#backoffice-ticketing .delete-form')

function showAllTicketing() {
    ticketingPermanentDivs.forEach(ticketingPermanentDiv => {
        ticketingPermanentDiv.style.display = 'block'
    });
    ticketingLimitedDivs.forEach(ticketingLimitedDiv => {
        ticketingLimitedDiv.style.display = 'block'
    });
}

function showTicketingPermanent() {
    ticketingPermanentDivs.forEach(ticketingPermanentDiv => {
        ticketingPermanentDiv.style.display = 'block'
    });
    ticketingLimitedDivs.forEach(ticketingLimitedDiv => {
        ticketingLimitedDiv.style.display = 'none'
    });
}

function showTicketingLimited() {
    ticketingPermanentDivs.forEach(ticketingPermanentDiv => {
        ticketingPermanentDiv.style.display = 'none'
    });
    ticketingLimitedDivs.forEach(ticketingLimitedDiv => {
        ticketingLimitedDiv.style.display = 'block'
    });
}

function onChangeTicketingAdd() {
    if (typeTicketing.value === '0') {
        orderNumberTicketing.style.display = 'flex'
        numberMinPlaceTicketing.style.display = 'none'
    }
    else if (typeTicketing.value === '1') {
        orderNumberTicketing.style.display = 'none'
        numberMinPlaceTicketing.style.display = 'flex'
    }
}

const handleClick = (e) => {

    // Récupération du nouveau bouton cliquer
    ticketingUnderline = document.querySelector(".ticketing-underline")

    // Récupération de l'ancien bouton cliquer, de sa taille en largeur et de sa position left
    previous = document.querySelector(".li-ticketing-active")
    previous.style.width = document.querySelector(".li-ticketing-active").offsetWidth + "px"
    previous.style.left = document.querySelector(".li-ticketing-active").offsetLeft + "px"

    // On enlève la classe li-ticketing-active de l'ancien bouton cliquer
    previous.classList.remove("li-ticketing-active")

    // On donne la classe li-ticketing-active au nouveau bouton cliquer
    e.target.classList.add("li-ticketing-active")

    // On récupère pour l'underline, la taille en largeur et la position left du nouveau bouton cliquer
    ticketingUnderline.style.width = document.querySelector(".li-ticketing-active").offsetWidth + "px"
    ticketingUnderline.style.left = document.querySelector(".li-ticketing-active").offsetLeft + "px"

    // Création d'une timeline et paused sur true pour pas que ça se lance des le load de la page
    const timeline = gsap.timeline({ paused: true });

    // Slide de l'underline de l'ancien bouton au nouveau
    timeline.fromTo(ticketingUnderline, { width: previous.style.width, left: previous.style.left }, { width: ticketingUnderline.style.width, left: ticketingUnderline.style.left, duration: 0.5 });

    // On joue la timeline
    timeline.play();
}

btnAllTicketing.addEventListener('click', showAllTicketing)
btnPermanentTicketing.addEventListener('click', showTicketingPermanent)
btnLimitedTicketing.addEventListener('click', showTicketingLimited)

numberMinPlaceTicketing.style.display = 'none'
typeTicketing.addEventListener('change', onChangeTicketingAdd)

buttons.forEach(btn => {
    btn.addEventListener('click', handleClick)
});


// Ticketing request

// choix des images

const labelFileAdds = document.querySelectorAll('.add-ticketing .card .card-image label')
const ticketingImgAdds = document.querySelectorAll('.add-ticketing .card .card-image img')
// const labelsFile = document.querySelectorAll('.members .card .card-image label')
// const memberImgs = document.querySelectorAll('.members .card .card-image img')

const handleChangeImageClick = (e, type, nbImage, index = null) => {
    e.preventDefault()
    let inputfiles = []
    let inputfile = null
    if (type === 'add') {
        inputfiles = document.querySelectorAll('.add-ticketing .card input[type=file]')
        inputfile = inputfiles[nbImage]
    }
    // else if (type === 'edit') {
    //     inputfile = document.querySelector('.ticketings .card:nth-child(' + (index + 1) + ') input[type=file]')
    // }
    inputfile.click()
}

labelFileAdds.forEach((labelFileAdd, nbImage) => {
    console.log(nbImage);
    labelFileAdd.addEventListener('click', (e) => handleChangeImageClick(e, 'add', nbImage))
});

ticketingImgAdds.forEach((ticketingImgAdd, nbImage) => {
    ticketingImgAdd.addEventListener('click', (e) => handleChangeImageClick(e, 'add', nbImage))
});

// labelsFile.forEach((label, index) => {
//     label.addEventListener('click', (e) => handleChangeImageClick(e, 'edit', index))
// })

// memberImgs.forEach((img, index) => {
//     img.addEventListener('click', (e) => handleChangeImageClick(e, 'edit', index))
// })

// gestion CRUD
// afficher le modal concerné
const handleTicketingsDisplayModal = (e, index, type, btnSubmit, form) => {
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
        deleteFullName.innerHTML = '- Membre : <b>' + formData.get('member[firstName]') + ' ' + formData.get('member[lastName]' + '</b>')

        // Fin du traitement de l'affichage 

        // garder la fonction submit dans une constante
        const submit = () => {
            handleSubmit(index, formData, form, type, 0), { once: true }
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
        const addType = document.querySelector('.modal .add-ticketing-type')
        const addName = document.querySelector('.modal .add-ticketing-name')
        const addText = document.querySelector('.modal .add-ticketing-text')
        const addDateStart = document.querySelector('.modal .add-ticketing-date-start')
        const addDateEnd = document.querySelector('.modal .add-ticketing-date-end')

        const addPartnership = document.querySelector('.modal .add-ticketing-partnership')
        const addNumberMin = document.querySelector('.modal .add-ticketing-number-min')
        const addOrderNumber = document.querySelector('.modal .add-ticketing-order-number')

        const addImage1 = document.querySelector('.modal .add-ticketing-image-1')
        const addImage2 = document.querySelector('.modal .add-ticketing-image-2')
        const addImage3 = document.querySelector('.modal .add-ticketing-image-3')
        const addImage4 = document.querySelector('.modal .add-ticketing-image-4')


        // Affichage des champs
        addType.innerHTML = '- Type de l\'offre : ' + '<b>' + formData.get('ticketing[type]') + '</b>'

        if (formData.get('ticketing[type]') === '0') {
            addType.innerHTML = '- Type de l\'offre : <b>Permanente</b>'
        } else {
            addType.innerHTML = '- Type de l\'offre : <b>Limitée</b>'
        }

        addName.innerHTML = '- Nom : <b>' + formData.get('ticketing[name]') + '</b>'
        addText.innerHTML = '- Text : <b>' + formData.get('ticketing[text]') + '</b>'
        addDateStart.innerHTML = '- Date de début : <b>' + formData.get('ticketing[date_start]') + '</b>'
        addDateEnd.innerHTML = '- Date de fin : <b>' + formData.get('ticketing[date_end]') + '</b>'
        addImage1.innerHTML = '- Image 1 : <b>' + formData.get('ticketing[image1]').name + '</b>'

        if (formData.get('ticketing[partnership]') === '') {
            addPartnership.innerHTML = '- Partenaire associé : <b> Aucun partenaire renseigné </b>'
        } else {
            addPartnership.innerHTML = '- Partenaire associé : <b>' + formData.get('ticketing[partnership]') + '</b>'
        }

        if (formData.get('ticketing[type]') === '0') {
            if (formData.get('ticketing[order_number]') === '0') {
                addNumberMin.innerHTML = '- Place nécessaire minimum : <b> 0 </b>'
            } else {
                addNumberMin.innerHTML = '- Place nécessaire minimum : <b>' + formData.get('ticketing[number_min_place]') + '</b>'
            }
        }

        if (formData.get('ticketing[type]') === '1') {
            if (formData.get('ticketing[order_number]') === '0') {
                addOrderNumber.innerHTML = '- Ordre d\'affichage : <b> Ne pas apparaître </b>'
            } else {
                addOrderNumber.innerHTML = '- Ordre d\'affichage : <b>' + formData.get('ticketing[order_number]') + '</b>'
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
            handleSubmit(index, formData, form, type, 0), { once: true }
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

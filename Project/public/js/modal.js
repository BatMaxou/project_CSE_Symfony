/*
*   INCLUDE AVANT REQUEST
*/
const modalBackgroundInfo = document.querySelector('.modal-background-info');
const modalBackgroundAdd = document.querySelector('.modal-background-add');
const modalBackgroundEdit = document.querySelector('.modal-background-edit');
const modalBackgroundDelete = document.querySelector('.modal-background-delete');

const isInputsRequiredNull = (target) => {
    let parent = target.parentElement
    // récupérer la card prent
    while (!parent.classList.contains('card')) {
        parent = parent.parentElement
    }
    // récupérer les inputs de la carte
    const inputs = parent.querySelectorAll('input[required = "required"], textarea[required = "required"]')
    let display = true
    inputs.forEach(input => {
        if (input.value.replace(' ', '') === '') {
            display = false
            if (input.type === 'file') {
                input.previousElementSibling.style.borderColor = 'var(--color-danger)'
            } else {
                input.style.borderColor = 'var(--color-danger)'
            }
        } else {
            if (input.type === 'file') {
                input.previousElementSibling.style.borderColor = 'var(--color-primary)'
            } else {
                input.style.borderColor = 'var(--color-primary)'
            }
        }
    });

    if (display) {
        return false
    }

    return true
}

// Géerer la hauteur selon l'appareil
const handleHeightChange = (modal, modalHeader, modalBody, modalFooter) => {
    const totalModalHeight = modal.clientHeight + modalHeader.clientHeight + modalFooter.clientHeight + 40
    const maxHeight = window.innerHeight * 90 / 100

    // si le modal est trop grand alors on limite la hauteur du contenu
    if (maxHeight < totalModalHeight) {
        modalBody.style.height = maxHeight - modalHeader.clientHeight - modalFooter.clientHeight - 40 + 'px'
    }
}

function openModal(modalBackground, modal, modalHeader, modalBody, modalFooter) {

    // création d'une timeline et paused sur true pour pas que ça se lance des le load de la page
    const timeline = gsap.timeline({ paused: true })

    // -25 pour le faire apparaitre de haut en bah centré progressivement de 50 px
    timeline.from(modal, { top: 0, opacity: 0, duration: 0.5 })

    modalBackground.style.display = 'block';
    handleHeightChange(modal, modalHeader, modalBody, modalFooter)

    const modalFooterText = modal.querySelector(".modal-text-footer")

    if (!modalFooterText) {
        const btnContainer = modal.querySelector(".btn-container")
        btnContainer.style.width = "100%"
    }

    // on joue la timeline
    timeline.restart()
}

function closeModal(modalBackground) {
    modalBackground.style.display = 'none';
}

if (modalBackgroundAdd) {
    let modalAdd = modalBackgroundAdd.querySelector('.modal')
    let modalHeader = modalBackgroundAdd.querySelector('.modal-header');
    let modalBody = modalBackgroundAdd.querySelector('.modal-body');
    let modalFooter = modalBackgroundAdd.querySelector('.modal-footer');
    let btnOpenAdd = document.querySelector('.modal-open-add')
    let modalClose = modalBackgroundAdd.querySelector('.modal-close');
    let btnClose = modalBackgroundAdd.querySelector('.btn-close');

    window.addEventListener("resize", () => handleHeightChange(modalAdd, modalHeader, modalBody, modalFooter))

    btnOpenAdd.addEventListener('click', (e) => {
        if (!isInputsRequiredNull(e.target)) {
            openModal(modalBackgroundAdd, modalAdd, modalHeader, modalBody, modalFooter)
        }
    })

    modalClose.addEventListener('click', () => modalBackgroundAdd.style.display = "none");
    btnClose.addEventListener('click', () => closeModal(modalBackgroundAdd));

    // pour fermer lorsqu'on clique en dehors du modal  
    modalBackgroundAdd.addEventListener('click', (event) => {
        if (event.target == modalBackgroundAdd) {
            closeModal(event.target);
        }
    })
}

if (modalBackgroundEdit) {
    let modalEdit = modalBackgroundEdit.querySelector('.modal')
    let modalHeader = modalBackgroundEdit.querySelector('.modal-header');
    let modalBody = modalBackgroundEdit.querySelector('.modal-body');
    let modalFooter = modalBackgroundEdit.querySelector('.modal-footer');
    let btnOpenEdits = document.querySelectorAll('.modal-open-edit')
    let modalClose = modalBackgroundEdit.querySelector('.modal-close');
    let btnClose = modalBackgroundEdit.querySelector('.btn-close');

    window.addEventListener("resize", () => handleHeightChange(modalEdit, modalHeader, modalBody, modalFooter))

    btnOpenEdits.forEach(btnOpenEdit => {
        btnOpenEdit.addEventListener('click', (e) => {
            if (!isInputsRequiredNull(e.target)) {
                openModal(modalBackgroundEdit, modalEdit, modalHeader, modalBody, modalFooter)
            }
        })
    });
    modalClose.addEventListener('click', () => modalBackgroundEdit.style.display = "none");
    btnClose.addEventListener('click', () => closeModal(modalBackgroundEdit));

    // pour fermer lorsqu'on clique en dehors du modal  
    modalBackgroundEdit.addEventListener('click', (event) => {
        if (event.target == modalBackgroundEdit) {
            closeModal(event.target);
        }
    })
}

if (modalBackgroundDelete) {
    let modalDelete = modalBackgroundDelete.querySelector('.modal')
    let modalHeader = modalBackgroundDelete.querySelector('.modal-header');
    let modalBody = modalBackgroundDelete.querySelector('.modal-body');
    let modalFooter = modalBackgroundDelete.querySelector('.modal-footer');
    let btnOpenDeletes = document.querySelectorAll('.modal-open-delete')
    let modalClose = modalBackgroundDelete.querySelector('.modal-close');
    let btnClose = modalBackgroundDelete.querySelector('.btn-close');

    window.addEventListener("resize", () => handleHeightChange(modalDelete, modalHeader, modalBody, modalFooter))

    btnOpenDeletes.forEach(btnOpenDelete => {
        btnOpenDelete.addEventListener('click', () => openModal(modalBackgroundDelete, modalDelete, modalHeader, modalBody, modalFooter))
    });
    modalClose.addEventListener('click', () => closeModal(modalBackgroundDelete));
    btnClose.addEventListener('click', () => closeModal(modalBackgroundDelete));

    // pour fermer lorsqu'on clique en dehors du modal  
    modalBackgroundDelete.addEventListener('click', (event) => {
        if (event.target == modalBackgroundDelete) {
            closeModal(event.target);
        }
    })
}

if (modalBackgroundInfo) {
    let modalInfo = modalBackgroundInfo.querySelector('.modal')
    let modalHeader = modalBackgroundInfo.querySelector('.modal-header');
    let modalBody = modalBackgroundInfo.querySelector('.modal-body');
    let modalFooter = modalBackgroundInfo.querySelector('.modal-footer');
    let btnOpenInfos = document.querySelectorAll('.modal-open-info')
    let modalClose = modalBackgroundInfo.querySelector('.modal-close');
    let btnClose = modalBackgroundInfo.querySelector('.btn-close');

    window.addEventListener("resize", () => handleHeightChange(modalInfo, modalHeader, modalBody, modalFooter))

    btnOpenInfos.forEach(btnOpenInfo => {
        btnOpenInfo.addEventListener('click', () => openModal(modalBackgroundInfo, modalInfo, modalHeader, modalBody, modalFooter))
    });
    modalClose.addEventListener('click', () => closeModal(modalBackgroundInfo));
    btnClose.addEventListener('click', () => closeModal(modalBackgroundInfo));

    // pour fermer lorsqu'on clique en dehors du modal  
    modalBackgroundInfo.addEventListener('click', (event) => {
        if (event.target == modalBackgroundInfo) {
            closeModal(event.target);
        }
    })
}
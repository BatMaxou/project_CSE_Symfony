/*
*   INCLUDE FLASH AVANT REQUEST
*/

const modalBackgroundInfo = document.querySelector('.modal-background-info');
const modalBackgroundEdit = document.querySelector('.modal-background-edit');
const modalBackgroundDelete = document.querySelector('.modal-background-delete');

// A voir plus tard
const handleHeightChange = (modal, modalHeader, modalBody, modalFooter) => {
    // modalBody.style.height = modal.clientHeight - modalHeader.clientHeight - modalFooter.clientHeight - 40 + 'px'
    // console.log(modal.clientHeight);
    // console.log(modalHeader.clientHeight);
    // console.log(modalFooter.clientHeight);
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
        btnOpenEdit.addEventListener('click', () => openModal(modalBackgroundEdit, modalEdit, modalHeader, modalBody, modalFooter))
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
    let modalDelete = modalBackgroundInfo.querySelector('.modal')
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
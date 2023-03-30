const modalBackground = document.querySelector('.modal-background');
const modalOpen = document.querySelector('.modal-open');
const modalClose = document.querySelector('.modal-close');
const modal = document.querySelector('.modal');
const modalHeader = modal.querySelector('.modal-header');
const modalBody = modal.querySelector('.modal-body');
const modalFooter = modal.querySelector('.modal-footer');
const btnClose = document.querySelector('.btn-close');

// gestion hauteur du modal
let modalHeaderHeight = 0
let modalFooterHeight = 0

const handleHeightChange = () => {
    modalBody.style.height = modal.clientHeight - modalHeader.clientHeight - modalFooter.clientHeight - 40 + 'px'
}

window.addEventListener("resize", handleHeightChange)

// création d'une timeline et paused sur true pour pas que ça se lance des le load de la page
const timeline = gsap.timeline({ paused: true });

// -25 pour le faire apparaitre de haut en bah centré progressivement de 50 px
timeline.from(modal, { y: '-25px', duration: 0.5 })

function openModal() {
    modalBackground.style.display = 'block';
    handleHeightChange()

    // on joue la timeline
    timeline.restart()
}

function closeModal() {
    modalBackground.style.display = 'none';
}

modalOpen.addEventListener('click', openModal);
modalClose.addEventListener('click', closeModal);
btnClose.addEventListener('click', closeModal);

// pour fermer lorsqu'on clique en dehors du modal
modalBackground.addEventListener('click', (event) => {
    // si l'élèment sur lequel l'utilisateur a cliqué === à l'lélèment qu'on a sélectionné 
    if (event.target === modalBackground) {
        closeModal();
    }
});
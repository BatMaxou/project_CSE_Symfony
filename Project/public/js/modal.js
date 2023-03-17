const modalBackground = document.querySelector('.modal-background');
const modalOpen = document.querySelector('.modal-open');
const modalClose = document.querySelector('.modal-close');
const modal = document.querySelector('.modal');
const btnClose = document.querySelector('.btnClose');

// création d'une timeline et paused sur true pour pas que ça se lance des le load de la page
const timeline = gsap.timeline({ paused: true });

// -50 pour le faire apparaitre de haut en bah centré progressivement de 50 px
timeline.from(modal, { y: -100, duration: 0.5 });

// on joue la timeline
timeline.play();

function openModal() {
    modalBackground.style.display = 'block';
    // réinitialisé la timeline
    timeline.restart();
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
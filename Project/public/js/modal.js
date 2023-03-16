const modal = document.querySelector('.modal');
const modalOpen = document.querySelector('.modal-open');
const modalClose = document.querySelector('.modal-close');
const modalContent = document.querySelector('.modal-content');
const btnClose = document.querySelector('.btnClose');

// création d'une timeline et paused sur true pour pas que ça se lance des le load de la page
const timeline = gsap.timeline({ paused: true });

// -50 pour le faire apparaitre de haut en bah centré progressivement de 50 px
timeline.from(modalContent, { y: -50, duration: 0.5 });

// on joue la timeline
timeline.play();

function openModal() {
    modal.style.display = 'block';
    // réinitialisé la timeline
    timeline.restart();
}

function closeModal() {
    modal.style.display = 'none';
}

modalOpen.addEventListener('click', openModal);
modalClose.addEventListener('click', closeModal);
btnClose.addEventListener('click', closeModal);

// pour fermer lorsqu'on clique en dehors du modal
modal.addEventListener('click', (event) => {
    // si l'élèment sur lequel l'utilisateur a cliqué === à l'lélèment qu'on a sélectionné 
    if (event.target === modal) {
        closeModal();
    }
});
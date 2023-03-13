// Récupérer les éléments du DOM
var slides = null
var prevBtn = null
var nextBtn = null

slides = document.querySelectorAll('#body .slider-image');
prevBtn = document.querySelector('#body .prev');
nextBtn = document.querySelector('#body .next');

// Initialiser le compteur
var currentSlide = 0;

// Afficher la première diapositive
if (slides.length !== 0) {
    showSlide(currentSlide);
}

// Fonction pour afficher une diapositive
function showSlide(index) {
    // Masquer toutes les diapositives
    gsap.set(slides, { display: 'none', opacity: 0 });

    // Afficher la diapositive actuelle
    gsap.set(slides[index], { display: 'block' });

    // Animer l'opacité de la diapositive actuelle
    gsap.to(slides[index], 0.5, { opacity: 1 });
}

// Fonction pour passer à la diapositive suivante
function nextSlide() {
    // Incrémenter le compteur
    currentSlide++;

    // Vérifier si on est à la fin du tableau
    if (currentSlide === slides.length) {
        currentSlide = 0;
    }

    // Afficher la diapositive suivante
    showSlide(currentSlide);
}

// Fonction pour passer à la diapositive précédente
function prevSlide() {
    // Décrémenter le compteur
    currentSlide--;

    // Vérifier si on est au début du tableau
    if (currentSlide < 0) {
        currentSlide = slides.length - 1;
    }

    // Afficher la diapositive précédente
    showSlide(currentSlide);
}

// Ajouter des écouteurs d'événements sur les flèches de navigation
if (nextBtn && prevBtn) {
    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);
}

// Définir un intervalle pour passer automatiquement à la diapositive suivante
var interval = setInterval(prevSlide, 3000);
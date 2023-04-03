// toutes les cartes d'offres
const offers = document.querySelectorAll('#homepage .card-paging')
// elements de pagination
const pagingElements = document.querySelectorAll('#homepage .paging-element')
const pagingSelect = document.querySelector('#homepage .paging-select')
const pagingSelectBetween = document.querySelector('#homepage .paging-between')

// s'il y a plus de 5 pages
if (pagingSelect) {
    const pagingSelectElements = pagingSelect.querySelectorAll('p')

    pagingSelectElements.forEach(element => {
        element.addEventListener('click', () => handlePagingNumClick(element))
    })
}

// recuperer le numero de l'a derniere page
const lastPage = parseInt(pagingElements[pagingElements.length - 2].querySelector('span').textContent)

let currentPage = 1
let previousPage = null
let pagingSelectDisplay = false

const displayElements = () => {
    // enlever les cartes d'offre de l'ancienne page si elles existent
    if (previousPage !== null) {
        for (let i = 5 * (previousPage - 1); i < (5 * previousPage); i++) {
            if (offers[i]) {
                offers[i].style.display = 'none'
            }
        }
    }
    // afficher les cartes d'offre de la page choisie
    for (let i = 5 * (currentPage - 1); i < (5 * currentPage); i++) {
        if (offers[i]) {
            offers[i].style.display = 'block'
        }
    }
}

const handlePageChangement = (nb) => {
    // enlever la classe active
    document.querySelector('.paging-element-active').classList.remove('paging-element-active')
    if (!pagingSelect) {
        // s'il y a moins de 5 pages, nb correspond à l'index de l'élément actif dans pagingElements
        pagingElements[nb].classList.add('paging-element-active')
    } else {
        // autrement traitement pour le choix du bon index
        if (!((nb <= 2 && nb > 0) || (nb <= lastPage && nb >= lastPage - 1))) {
            pagingSelectBetween.textContent = nb
            pagingElements[3].classList.add('paging-element-active')
        } else {
            pagingSelectBetween.textContent = ''
            if (nb <= 2 && nb > 0) {
                pagingElements[nb].classList.add('paging-element-active')
            } else if (nb <= lastPage && nb >= lastPage - 1) {
                // nb d'élément (avec les 2 flèches) - 2 (enlever les flèches) + nb de la page souhaiter - nb total de page
                pagingElements[pagingElements.length - 2 + nb - lastPage].classList.add('paging-element-active')
            }
        }
    }
}

// gestion de l'affichage du select
const handlePagingSelectClick = (el) => {
    if (pagingSelectDisplay) {
        pagingSelectDisplay = false
        el.querySelector('.paging-between').style.display = 'block'
        el.querySelector('.paging-select').style.display = 'none'
    } else {
        pagingSelectDisplay = true
        el.querySelector('.paging-between').style.display = 'none'
        el.querySelector('.paging-select').style.display = 'block'
    }
}

const handlePagingArrowClick = (el) => {
    previousPage = currentPage
    if (el.querySelector('img').classList.contains('previous')) {
        if (currentPage - 1 > 1) {
            currentPage--
            displayElements()
            handlePageChangement(currentPage)
        } else if (currentPage - 1 === 1) {
            currentPage--
            displayElements()
            handlePageChangement(currentPage)
            el.classList.add('paging-disabled')
        } else {
            el.classList.add('paging-disabled')
        }
    } else {

        if (currentPage + 1 < lastPage) {
            currentPage++
            displayElements()
            handlePageChangement(currentPage)
        } else if (currentPage + 1 === lastPage) {
            currentPage++
            displayElements()
            handlePageChangement(currentPage)
            el.classList.add('paging-disabled')
        } else {
            el.classList.add('paging-disabled')
        }
    }
}

const handlePagingNumClick = (span) => {
    previousPage = currentPage
    currentPage = parseInt(span.textContent)
    if (currentPage === lastPage) {
        pagingElements[pagingElements.length - 1].classList.add('paging-disabled')
    } else if (currentPage === 1) {
        pagingElements[0].classList.add('paging-disabled')
    }
    displayElements()
    handlePageChangement(currentPage)
}

const handlePagingElementClick = (el) => {
    const clicked = document.querySelector('#homepage .paging-element-clicked')
    if (clicked) {
        clicked.classList.remove('paging-element-clicked')
    }
    el.classList.add('paging-element-clicked')

    pagingElements.forEach(el => {
        el.classList.remove('paging-disabled')
    })

    if (el.querySelector('.paging-select')) {
        handlePagingSelectClick(el)
    } else if (el.querySelector('img')) {
        handlePagingArrowClick(el)
    } else {
        handlePagingNumClick(el.querySelector('span'))
    }
}

pagingElements.forEach(element => {
    element.addEventListener('click', () => handlePagingElementClick(element))
})

// affichage par défaut
pagingElements[0].classList.add('paging-disabled')
displayElements()
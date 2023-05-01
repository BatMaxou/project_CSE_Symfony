const pagingContainers = document.querySelectorAll('.paging-container')

if (pagingContainers.length !== 0) {
    pagingContainers.forEach((container, index) => {
        let offers = []
        // séparé les différents systèmes de paging sur la même page
        if (index === 0 && document.querySelector('.card-paging')) {
            // toutes les cartes concernées par la première pagination
            offers = document.querySelectorAll('.card-paging')
        } else {
            // toutes les cartes concernées par la pagination d'index
            offers = document.querySelectorAll('.card-paging-' + (index + 1))
        }
        // elements de pagination
        const pagingElements = container.querySelectorAll('.paging-element')
        const pagingSelect = container.querySelector('.paging-select')
        const pagingSelectBetween = container.querySelector('.paging-between')

        // recuperer le numero de l'a derniere page
        const lastPage = parseInt(pagingElements[pagingElements.length - 2].querySelector('span').textContent)

        const disableArrow = (props = { previous: true, next: true }) => {
            if (props.previous) {
                pagingElements[0].classList.add('paging-disabled')
            }
            if (props.next) {
                pagingElements[pagingElements.length - 1].classList.add('paging-disabled')
            }
        }

        let currentPage = 1
        let previousPage = null
        let pagingSelectDisplay = false

        const displayElements = (isDefault = false) => {
            // enlever les cartes d'offre de l'ancienne page si elles existent
            if (previousPage !== null) {
                for (let i = 4 * (previousPage - 1); i < (4 * previousPage); i++) {
                    if (offers[i]) {
                        offers[i].style.display = 'none'
                    }
                }
            }
            // afficher les cartes d'offre de la page choisie
            for (let i = 4 * (currentPage - 1); i < (4 * currentPage); i++) {
                if (offers[i]) {
                    offers[i].style.display = 'block'
                }
            }
            // masquer les flèches si il n'y a qu'une page
            // sinon masquer la prmière flèche si on précise que l'on est dans la situation par défaut
            if (pagingElements.length <= 3) {
                disableArrow()
            } else if (isDefault) {
                disableArrow({ previous: true, next: false })
            }
        }

        const handlePageChangement = (nb) => {
            // enlever la classe active
            container.querySelector('.paging-element-active').classList.remove('paging-element-active')
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
                    handlePageChangement(currentPage)
                    displayElements()
                } else if (currentPage - 1 === 1) {
                    currentPage--
                    handlePageChangement(currentPage)
                    displayElements()
                    disableArrow({ previous: true, next: false })
                } else {
                    displayElements()
                    disableArrow({ previous: true, next: false })
                }
            } else if (el.querySelector('img').classList.contains('next')) {
                if (currentPage + 1 < lastPage) {
                    currentPage++
                    handlePageChangement(currentPage)
                    displayElements()
                } else if (currentPage + 1 === lastPage) {
                    currentPage++
                    handlePageChangement(currentPage)
                    displayElements()
                    disableArrow({ previous: false, next: true })
                } else {
                    displayElements()
                    disableArrow({ previous: false, next: true })
                }
            }
        }

        const handlePagingNumClick = (span) => {
            previousPage = currentPage
            currentPage = parseInt(span.textContent)
            handlePageChangement(currentPage)
            displayElements()
            if (currentPage === lastPage) {
                disableArrow({ previous: false, next: true })
            } else if (currentPage === 1) {
                disableArrow({ previous: true, next: false })
            }
        }

        const handlePagingElementClick = (el) => {
            const clicked = container.querySelector('.paging-element-clicked')
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

        // s'il y a plus de 5 pages
        if (pagingSelect) {
            const pagingSelectElements = pagingSelect.querySelectorAll('p')

            pagingSelectElements.forEach(element => {
                element.addEventListener('click', () => handlePagingNumClick(element))
            })
        }

        // affichage par défaut
        displayElements(true)
    })
}

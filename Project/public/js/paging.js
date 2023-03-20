const offers = document.querySelectorAll('#homepage .card-paging')
const pagingElements = document.querySelectorAll('#homepage .paging-element')
const pagingSelectElements = document.querySelectorAll('#homepage .paging-select p')
// get the number of the last page
const lastPage = parseInt(pagingElements[pagingElements.length - 2].querySelector('span').textContent)

let currentPage = 1
let previousPage = null
let pagingSelectDisplay = false

const displayElements = () => {
    // remove previous offer if exist and display the new ones
    if (previousPage !== null) {
        for (let i = 3 * (previousPage - 1); i < (3 * previousPage); i++) {
            if (offers[i]) {
                offers[i].style.display = 'none'
            }
        }
    }
    for (let i = 3 * (currentPage - 1); i < (3 * currentPage); i++) {
        if (offers[i]) {
            offers[i].style.display = 'block'
        }
    }
}

const handlePagingSelectClick = (select) => {
    if (pagingSelectDisplay) {
        pagingSelectDisplay = false
        select.style.display = 'none'
    } else {
        pagingSelectDisplay = true
        select.style.display = 'block'
    }
}

const handlePagingArrowClick = (el) => {
    previousPage = currentPage
    if (el.querySelector('img').classList.contains('previous')) {
        console.log('try', currentPage - 1, 'min', 1);
        if (currentPage - 1 > 1) {
            currentPage--
            displayElements()
        } else if (currentPage - 1 === 1) {
            currentPage--
            displayElements()
            el.classList.add('paging-disabled')
        } else {
            el.classList.add('paging-disabled')
        }
    } else {
        console.log(currentPage);
        console.log('try', currentPage + 1, 'max', lastPage);

        if (currentPage + 1 < lastPage) {
            currentPage++
            displayElements()
        } else if (currentPage + 1 === lastPage) {
            currentPage++
            displayElements()
            el.classList.add('paging-disabled')
        } else {
            el.classList.add('paging-disabled')
        }
    }
}

const handlePagingNumClick = (span) => {
    previousPage = currentPage
    currentPage = parseInt(span.textContent)
    // just == because not same type (string, int)
    if (currentPage == lastPage) {
        pagingElements[pagingElements.length - 1].classList.add('paging-disabled')
    } else if (currentPage == 1) {
        pagingElements[0].classList.add('paging-disabled')
    }
    displayElements()
}

const handlePagingElementClick = (el) => {
    const active = document.querySelector('#homepage .paging-element-active')
    active.classList.remove('paging-element-active')
    el.classList.add('paging-element-active')

    pagingElements.forEach(el => {
        el.classList.remove('paging-disabled')
    })

    if (el.querySelector('.paging-select')) {
        handlePagingSelectClick(el.querySelector('.paging-select'))
    } else if (el.querySelector('img')) {
        handlePagingArrowClick(el)
    } else {
        handlePagingNumClick(el.querySelector('span'))
    }
}

pagingElements.forEach(element => {
    element.addEventListener('click', () => handlePagingElementClick(element))
})

pagingSelectElements.forEach(element => {
    element.addEventListener('click', () => handlePagingNumClick(element))
})

// default settings
pagingElements[0].classList.add('paging-disabled')
displayElements()
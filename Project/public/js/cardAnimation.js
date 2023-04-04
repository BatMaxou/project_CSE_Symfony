const cards = document.querySelectorAll('.card')
const saveBtns = document.querySelectorAll('.btn-save')

saveBtns.forEach(btn => {
    btn.style.display = 'none'
    btn.style.opacity = 0
})

// création d'une timeline et paused sur true pour pas que ça se lance des le load de la page
const deleteAnim = gsap.timeline({ paused: true });

const handleBtnDelete = (index) => {
    // e.preventDefault()

    // suppression de la hauteur de la carte sur 1 seconde puis supprimer du DOM
    deleteAnim.to(cards[index], {
        height: '0px',
        overflow: 'hidden',
        marginBottom: 0,
        marginTop: 0,
        opacity: 0,
        paddingTop: 0,
        paddingBottom: 0,
        duration: 1
    }).then(() => cards[index].style.display = 'none')

    // on joue la timeline
    deleteAnim.play()
}

const btnActived = document.querySelectorAll('.btn-actived')

// création d'une timeline et paused sur true pour pas que ça se lance des le load de la page
const activeAnim = gsap.timeline({ paused: true });

const handleBtnActive = (e, index) => {
    e.preventDefault()

    const saveBtn = cards[index].querySelector('.btn-save')
    const inputs = cards[index].querySelectorAll('input')
    const labelImg = cards[index].querySelector('label.form-file-label-disabled')

    inputs.forEach(input => {
        // rendre les input enabled
        input.disabled = false
        input.classList.remove('.form-input-disabled')

        // activer les champs
        activeAnim.to(input, {
            backgroundColor: 'transparent',
            duration: 0.2
        })

    })

    // activer les champs
    activeAnim.to(labelImg, {
        backgroundColor: 'transparent',
        borderColor: 'var(--color-primary)',
        duration: 0.2
    }).then(() => {
        labelImg.classList.remove('form-file-label-disabled')
        labelImg.classList.add('form-file-label-active')
    })

    activeAnim.to(e.target, {
        opacity: 0,
        display: 'none',
        duration: 0.4
    })

    activeAnim.to(saveBtn, {
        opacity: 1,
        display: 'block',
        duration: 0.4
    })

    // on joue la timeline
    activeAnim.play()

}

btnActived.forEach((btn, index) => {
    btn.addEventListener('click', (e) => handleBtnActive(e, index))
})
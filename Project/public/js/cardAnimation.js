const cards = document.querySelectorAll('.card')
const saveBtns = document.querySelectorAll('.btn-save')

saveBtns.forEach(btn => {
    btn.style.display = 'none'
    btn.style.opacity = 0
})

// création d'une timeline et paused sur true pour pas que ça se lance des le load de la page
const newCardAnim = gsap.timeline({ paused: true });

const handleAddCard = (cards, fade = false) => {
    // enlever la card d'ajout
    cards.splice(0, 1)

    cards.forEach((card, index) => {
        if (index === 0) {
            card.style.height = '0px'
            card.style.overflow = 'hidden'

            newCardAnim.to(card, {
                height: 'auto',
                duration: 1
            })
        } else if (window.innerWidth >= 850 && fade) {
            card.style.opacity = 0
            gsap.to(card, {
                opacity: 1,
                duration: 1.5
            })
        }
    })

    // on joue la timeline
    newCardAnim.play()
}

// création d'une timeline et paused sur true pour pas que ça se lance des le load de la page
const deleteAnim = gsap.timeline({ paused: true });

const handleBtnDelete = (index, cards, fade = false) => {
    // enlever la card d'ajout
    cards.splice(0, 1)

    cards.forEach((card, i) => {
        console.log(window.innerWidth, fade);
        if (i === index) {
            // suppression de la hauteur de la carte sur 1 seconde puis supprimer du DOM
            deleteAnim.to(card, {
                height: '0px',
                overflow: 'hidden',
                marginBottom: 0,
                marginTop: 0,
                opacity: 0,
                paddingTop: 0,
                paddingBottom: 0,
                duration: 1
            }).then(() => cards[index].style.display = 'none')

        } else if (i > index && window.innerWidth >= 850 && fade) {
            gsap.to(card, {
                opacity: 0,
                duration: 1
            }).then(() => {
                gsap.to(card, {
                    opacity: 1,
                    duration: 1
                })
            })
        }
    })

    // on joue la timeline
    deleteAnim.play()
}

// création d'une timeline et paused sur true pour pas que ça se lance des le load de la page
const editAnim = gsap.timeline({ paused: true });

const handleBtnEdit = (index) => {

    const editBtn = cards[index].querySelector('.btn-actived')
    const saveBtn = cards[index].querySelector('.btn-save')

    editAnim.to(saveBtn, {
        opacity: 0,
        display: 'none',
        duration: 0.4
    })

    editAnim.to(editBtn, {
        opacity: 1,
        display: 'block',
        duration: 0.4
    })

    // on joue la timeline
    editAnim.play()

    handleDesactive(index)
}

const btnActived = document.querySelectorAll('.btn-actived')

// création d'une timeline et paused sur true pour pas que ça se lance des le load de la page
const activeAnim = gsap.timeline({ paused: true });

const handleBtnActive = (e, index) => {
    e.preventDefault()

    const saveBtn = cards[index].querySelector('.btn-save')
    // precision de .edit-form pour exclure les inputs du formulaire de suppression
    const inputs = cards[index].querySelectorAll('.edit-form input, .edit-form textarea, .edit-form select')
    const labelImg = cards[index].querySelector('label.form-file-label-disabled')

    inputs.forEach(input => {
        // rendre les input enabled
        input.disabled = false
        input.classList.remove('.form-input-disabled')

        // activer les champs
        activeAnim.to(input, {
            backgroundColor: 'transparent',
            borderBottom: '1px solid #000',
            duration: 0.2
        })
    })

    if (labelImg) {
        // activer les champs
        activeAnim.to(labelImg, {
            backgroundColor: 'transparent',
            borderColor: 'var(--color-primary)',
            duration: 0.2
        }).then(() => {
            labelImg.classList.remove('form-file-label-disabled')
            labelImg.classList.add('form-file-label-active')
        })
    }

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

// création d'une timeline et paused sur true pour pas que ça se lance des le load de la page
const dasactiveAnim = gsap.timeline({ paused: true });

const handleDesactive = (index) => {

    // precision de .edit-form pour exclure les inputs du formulaire de suppression
    const inputs = cards[index].querySelectorAll('.edit-form input, .edit-form textarea, .edit-form select')
    const labelImg = cards[index].querySelector('label.form-file-label-active')

    inputs.forEach(input => {
        // rendre les input disabled
        input.disabled = true
        input.classList.add('.form-input-disabled')

        // dsactiver les champs
        dasactiveAnim.to(input, {
            backgroundColor: 'var(--color-disabled)',
            borderBottom: '1px solid transparent',
            duration: 0.2
        })
    })

    if (labelImg) {
        // activer les champs
        dasactiveAnim.to(labelImg, {
            backgroundColor: 'var(--color-disabled)',
            borderColor: 'transparent',
            duration: 0.2
        }).then(() => {
            labelImg.classList.remove('form-file-label-active')
            labelImg.classList.add('form-file-label-disabled')
        })
    }

    // on joue la timeline
    dasactiveAnim.play()
}

btnActived.forEach((btn, index) => {
    // +1 pour passer outre la card d'ajout
    btn.addEventListener('click', (e) => handleBtnActive(e, index + 1))
})

const dasactiveSurveyAnim = gsap.timeline({ paused: true });

// desactive tag sondage
const handleBtnEditDesactivateSurvey = (index) => {
    const tag = cards[index].querySelector('.card-tag')
    const btn = cards[index].querySelector('.card-date')

    dasactiveSurveyAnim.to(btn, {
        opacity: 0,
        duration: 0.2
    }).then(() => {
        btn.style.display = 'none'
        tag.textContent = 'sondage archivé'
    })

    dasactiveSurveyAnim.play()
}
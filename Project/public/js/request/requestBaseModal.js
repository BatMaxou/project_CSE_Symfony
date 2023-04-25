// si un GET est précisé et qu'il correspond à 'new=true', alors effectuer l'animation d'ajout et clear le GET
let getParameters = null

if ((getParameters = window.location.href.split('?')[1])
    && (getParameters = getParameters.split('&'))
    && (getParameters[0].split('=')[0] === 'new')
    && (getParameters[0].split('=')[1] === 'true')) {
    // passer outre la 'card' d'ajout
    // cards est recup dans cardAnimation.js
    // transform cards de nodelist a array 
    if (getParameters[1]
        && getParameters[1].split('=')[0] === 'offertype'
        && getParameters[1].split('=')[1] === 'limited') {
        window.history.replaceState({}, document.title, window.location.pathname);
    } else {
        handleAddCard(Array.from(cards), true)
        window.history.replaceState({}, document.title, window.location.pathname);
    }
}

// gérer la requête en ajax
const handleSubmit = async (index, formData, form, type, options = {}) => {

    let response = null

    if (type === 'edit') {
        response = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: formData
        })

        closeModal(document.querySelector('.modal-background-edit'))

        const msg = await response.text()

        if (response.status === 200) {
            // Card animation
            // index + 1 pour passer outre la première card d'ajout
            handleBtnEdit(index + 1)

            createFlash('alert-success', msg, 1)
        } else {
            createFlash('alert-error', msg)
        }
    }
    else if (type === 'delete') {
        response = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: formData
        })

        closeModal(document.querySelector('.modal-background-delete'))

        const msg = await response.text()

        if (response.status === 200) {
            // Card animation
            // 'cards' est défini dans cardAnimation.js
            handleBtnDelete(index, Array.from(cards))

            createFlash('alert-success', msg, 1)
        } else {
            createFlash('alert-error', msg)
        }
    }
    // vérification que la valeur donné de valid correspond à la valeur courante de valid
    else if (type === 'add') {
        response = await fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: formData
        })

        closeModal(document.querySelector('.modal-background-add'))

        const msg = await response.text()

        if (response.status === 200) {
            setTimeout(() => {
                if (options.addOffer) {
                    window.location.replace(window.location.href + '?new=true&offertype=' + options.addOffer)
                } else {
                    window.location.replace(window.location.href + '?new=true')
                }
            }, 1000)

            createFlash('alert-success', msg, 0.5)
        } else {
            createFlash('alert-error', msg)
        }
    }
}
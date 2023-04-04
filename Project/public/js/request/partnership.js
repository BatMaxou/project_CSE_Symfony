// request pour update partenariat dans backoffice
const partnerEditForm = document.querySelectorAll('#backoffice-partnership form')

if (partnerEditForm.length !== 0) {

    const handlePartnerEditSubmit = async (e) => {
        e.preventDefault()

        const response = await fetch(e.target.getAttribute('action'), {
            method: e.target.getAttribute('method'),
            body: new FormData(e.target)
        })

        const msg = await response.text()

        if (response.status === 200) {

            createFlash('alert-success', msg)
        } else {
            createFlash('alert-error', msg)
        }
    }

    partnerEditForm.forEach(form => {
        form.addEventListener('submit', (e) => handlePartnerEditSubmit(e))
    });

    const partnerDelete = document.querySelectorAll('#backoffice-partnership .btn-delete')

    partnerDelete.forEach(el => {
        const btnDelete = el.dataset.id
        el.addEventListener('click', (e) => deletePartnership(e))
    })

    const deletePartnership = async (e) => {
        e.preventDefault()

        console.log(e.target.dataset.id);

        const response = await fetch(e.target.getAttribute('action'), {
            method: e.target.getAttribute('method'),
            body: new FormData(e.target)
        })

        const msg = await response.text()

        if (response.status === 200) {

            createFlash('alert-success', msg)
        } else {
            createFlash('alert-error', msg)
        }
    }
}

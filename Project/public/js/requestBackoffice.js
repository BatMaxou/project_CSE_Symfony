// ckeditor request
const adminsForm = document.querySelectorAll('#backoffice-admin form')

if (adminsForm.length != 0) {

    const handleAdminsSubmit = async (e) => {
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

    adminsForm.forEach(element => {
        element.addEventListener('submit', handleAdminsSubmit)
    });
}

// ckeditor request
const textsForm = document.querySelector('#texts form')
if (textsForm) {
    const handleTextsSubmit = async (e) => {
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


    textsForm.addEventListener('submit', handleTextsSubmit)
}

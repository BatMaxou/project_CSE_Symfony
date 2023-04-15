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
            createFlash('alert-success', msg, 0.5)
        } else {
            createFlash('alert-error', msg)
        }
    }


    textsForm.addEventListener('submit', handleTextsSubmit)
}

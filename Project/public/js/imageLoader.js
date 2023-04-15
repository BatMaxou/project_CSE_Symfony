const fileInputs = document.querySelectorAll('.card-image .form-file-input')
const fileRepresentations = document.querySelectorAll('.card-image img')

const handleFileChange = (e, index) => {
    const file = e.target.files
    if (file[0]) {
        fileRepresentations[index].src = window.URL.createObjectURL(file[0])
    }
}

fileInputs.forEach((input, index) => {
    input.addEventListener('change', (e) => handleFileChange(e, index))
})
const handleDisplayAddSurveyChart = () => {
    const chart = document.querySelector('.chart-add-survey')
    const nbResponses = document.querySelectorAll('.add-survey .responses .response').length

    const data = []
    for (let index = 0; index < nbResponses; index++) {
        data.push(1)
    }

    const newChart = document.createElement('canvas')
    newChart.classList.add('chart-add-survey')

    chart.replaceWith(newChart)

    const dataAddSurvey = {
        datasets: [
            {
                data: data,
                label: ['--Exemple-- Nombre de vote '],
                backgroundColor: [
                    '#36a2eb',
                    '#ff6384',
                    '#4bc0c0',
                    '#ff9f40',
                    '#9966ff',
                    '#ffcd56',
                    '#c9cbcf'
                ],
                // plus c'est grand plus ça met de l'espace entre chaque section du grave au hover
                hoverOffset: 5
            }
        ]
    }

    new Chart(newChart, {
        type: 'doughnut',
        data: dataAddSurvey,
    })
}

handleDisplayAddSurveyChart()

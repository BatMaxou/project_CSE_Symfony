const charts = document.querySelectorAll('.chart');
const totalResponse = document.querySelectorAll('.total-response');
const response = []
let card = [];

if (document.querySelector('#dashboard')) {
    card = document.querySelectorAll('#survey-active-dashboard .card')
} else {
    card = document.querySelectorAll('.surveys .card')
}

card.forEach((e, i) => {
    response[i] = []
    const resultResponse = e.querySelectorAll('.result-response')
    resultResponse.forEach((n) => {
        if (n.textContent.replace("%", "").replace(" ", "") * totalResponse[i].textContent / 100 % 1 == 0) {
            response[i].push(~~(n.textContent.replace("%", "").replace(" ", "") * totalResponse[i].textContent / 100))
        } else {
            response[i].push(~~(n.textContent.replace("%", "").replace(" ", "") * totalResponse[i].textContent / 100) + 1)
        }
    })
})

charts.forEach((chart, index) => {
    const data = {
        datasets: [
            {
                data: response[index],
                label: [' Nombre de vote '],
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
    };

    new Chart(chart, {
        type: 'doughnut',
        data: data,
    });
});

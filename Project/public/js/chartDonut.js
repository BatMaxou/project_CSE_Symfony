const charts = document.querySelectorAll('.chart');
const totalResponse = document.querySelectorAll('.totalResponse');
const reponse = []
let card = [];
let ignored = false;
let nb = 0

if (document.querySelector('#dashboard')) {
    card = document.querySelectorAll('#survey-active-dashboard .card')
} else {
    ignored = true
    card = document.querySelectorAll('.card')
}

if (ignored) {
    nb = 1
}

card.forEach((e, i) => {
    if (i != 0 || !ignored) {
        reponse[i] = []
        const resultResponse = e.querySelectorAll('.resultResponse')
        resultResponse.forEach((n) => {
            if (n.textContent.replace("%", "").replace(" ", "") * totalResponse[i - nb].textContent / 100 % 1 == 0) {
                reponse[i].push(~~(n.textContent.replace("%", "").replace(" ", "") * totalResponse[i - nb].textContent / 100))
            } else {
                reponse[i].push(~~(n.textContent.replace("%", "").replace(" ", "") * totalResponse[i - nb].textContent / 100) + 1)
            }
        })
    }
})

charts.forEach((chart, index) => {
    const data = {
        datasets: [
            {
                data: reponse[index + nb],
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


// graph du dashboard qui illustre le nombre total de réponses pour les 5 derniers sondage
const ctx = document.getElementById('stat-cse');

const r = []
const rep = document.querySelectorAll('.q-stat')
rep.forEach((e) => {
    r.push(e.textContent.replace('\n', "").replace(/\t/g, "").replace('\n', ""))
})

const q = []
let k = []
let temp = []
const quest = document.querySelectorAll('.r-stat')
quest.forEach((el) => {
    q.push(el.textContent.replace('\n', "").replace(/\t/g, "").replace('\n', ""))
})
q.forEach((el) => {
    const split = el.split(' ')
    split.forEach((e, i) => {
        if ((i + 1) % 2 == 0) {
            temp.push(split[i - 1] + " " + e)
        }
    })
    if (split.length % 2 == 1) {
        temp.push(split[split.length - 1])
    }
    k.push(temp)
    temp = []
})

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: k,
        datasets: [
            {
                label: 'Nombre total de réponse pour le(s) ' + k.length + ' dernier(s) sondages',
                data: r,
                borderWidth: 1,
            }
        ]
    }
});
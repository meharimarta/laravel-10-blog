var ctx = document.getElementById('trafic-chart');
ctx.height = 300;
var viewChart = new Chart(ctx,{
    type: 'line',
    data: {
        labels: ['January','February','March','April','May','June','July','Ogust','September','Desember'],
        datasets: [{
            label: 'Trafic',
            data: [12,19,3,5,2,3,33,4,2,54,55,53],
            backgroundColor: 'rgba(33, 150, 243,0.2)',
            borderColor: '#E91E63',
            borderColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(34, 45, 43, 0.2)',
                'rgba(111, 34, 44, 0.2)',
                'rgba(11, 134, 0, 0.2)',
                'rgba(111, 34, 44, 0.2)'
            ],
            borderWidth: 5
        }]
    },
    options: {
        maintainAspectRetio: false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
})
document.addEventListener('DOMContentLoaded', function () {
    if (typeof datosGraficos === 'undefined') return;

    datosGraficos.forEach((item, index) => {
        const ctx = document.getElementById('grafico-' + index).getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['% Alcanzado', 'Faltante'],
                datasets: [{
                    data: [item.porcentaje, 100 - item.porcentaje],
                    backgroundColor: ['#0746b3', '#00c9fa'],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                    cutout: '75%',
                    circumference: 180,
                    rotation: -90,
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                width: 300,
                height: 150,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: item.name,
                        color: '#ffffff',
                        font: {
                            size: 20,
                            weight: 'bold'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ctx.label + ': ' + ctx.raw.toFixed(1) + '%'
                        }
                    }
                }
            },
            plugins: [ // Plugin para mostrar el porcentaje en el centro
                {
                    id: 'centerText',
                    beforeDraw: function (chart) {
                        const { width, height, ctx } = chart;
                        ctx.restore();
                        const fontSize = 20;
                        ctx.font = `${fontSize}px sans-serif`;
                        ctx.fillStyle = '#ffffff';
                        ctx.textBaseline = 'middle';

                        const text = item.porcentaje.toFixed(0) + '%';
                        const textX = Math.round((width - ctx.measureText(text).width) / 2);
                        const textY = height / 1.4;

                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
            ]
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('graficoInteligencias');
    if (ctx) {
        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nivel de Inteligencia (%)',
                    data: data,
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 30,
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        max: 100,
                        grid: { display: false },
                        ticks: {
                            callback: value => value + '%'
                        }
                    },
                    y: {
                        grid: { display: false }
                    }
                },
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ctx.parsed.x + '%'
                        }
                    }
                }
            }
        });
    }

    const ctxFortaleza = document.getElementById('graficoFortaleza');
    if (ctxFortaleza) {
        new Chart(ctxFortaleza.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labelsFortaleza,
                datasets: [{
                    label: 'Nivel de Inteligencia (%)',
                    data: dataFortaleza,
                    backgroundColor: [
                        '#4e73df',
                        '#1cc88a',
                        '#36b9cc',
                        '#f6c23e',
                        '#e74a3b',
                        '#858796',
                    ],                    
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 30,
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        max: 100,
                        grid: { display: false },
                        ticks: {
                            callback: value => value + '%'
                        }
                    },
                    y: {
                        grid: { display: false }
                    }
                },
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ctx.parsed.x + '%'
                        }
                    }
                }
            }
        });
    }
});

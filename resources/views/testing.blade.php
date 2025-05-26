<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawaban Responden Per Kategori Soal</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 24px;
        }

        #chartContainer {
            position: relative;
            height: 500px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Jawaban Responden Per Kategori Soal</h1>
        <div id="chartContainer">
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <script>
        // Chart data
        const data = {
            labels: ['U1', 'U2', 'U3', 'U4', 'U5', 'U6', 'U7', 'U8', 'U9'],
            datasets: [{
                label: 'Score',
                data: [3.5, 3.48, 3.41, 3.72, 3.48, 3.51, 3.52, 3.78, 3.43],
                backgroundColor: '#2196F3',
                borderColor: '#2196F3',
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false,
            }]
        };

        // Chart configuration
        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Mutu: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 4.0,
                        ticks: {
                            stepSize: 1.0,
                            callback: function(value) {
                                return value.toFixed(2);
                            }
                        },
                        grid: {
                            color: '#e0e0e0'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                // Display values inside bars
                onComplete: function(chart) {
                    const ctx = chart.chart.ctx;
                    ctx.font = 'bold 16px Arial';
                    ctx.fillStyle = 'white';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';

                    chart.data.datasets.forEach(function(dataset, i) {
                        const meta = chart.chart.getDatasetMeta(i);
                        meta.data.forEach(function(bar, index) {
                            const data = dataset.data[index];
                            // Position text in the middle of the bar
                            const yPosition = bar.y + (bar.height / 2);
                            ctx.fillText(data, bar.x, yPosition);
                        });
                    });
                }
            }
        };

        // Create the chart
        const ctx = document.getElementById('barChart').getContext('2d');
        const myChart = new Chart(ctx, config);
    </script>
</body>

</html>

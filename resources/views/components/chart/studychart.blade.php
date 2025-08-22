<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Statistics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

<div x-data="studyChart" x-init="renderChart()"
     class="bg-white rounded-2xl shadow-md p-5 w-full max-w-6xl">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Study Statistics</h2>
        <div class="flex items-center space-x-3 mt-2 sm:mt-0">
        <span class="flex items-center text-sm text-gray-600">
          <span class="w-2 h-2 bg-blue-500 rounded-full mr-1"></span> Study
        </span>
            <span class="flex items-center text-sm text-gray-600">
          <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span> Test
        </span>
            <div class="relative">
                <select class="text-sm border rounded-md px-2 py-1 focus:ring focus:ring-blue-300">
                    <option>Yearly</option>
                    <option>Monthly</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="w-full h-64 sm:h-80">
        <canvas id="studyChartCanvas"></canvas>
    </div>
</div>

<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("studyChart", () => ({
            renderChart() {
                const ctx = document.getElementById("studyChartCanvas").getContext("2d");

                const gradientBlue = ctx.createLinearGradient(0, 0, 0, 300);
                gradientBlue.addColorStop(0, "rgba(59,130,246,0.4)");
                gradientBlue.addColorStop(1, "rgba(59,130,246,0)");

                const gradientGreen = ctx.createLinearGradient(0, 0, 0, 300);
                gradientGreen.addColorStop(0, "rgba(16,185,129,0.4)");
                gradientGreen.addColorStop(1, "rgba(16,185,129,0)");

                new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [
                            {
                                label: "Study",
                                data: [5, 15, 12, 18, 25, 30, 15, 20, 10, 15, 12, 14],
                                borderColor: "#3B82F6",
                                backgroundColor: gradientBlue,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 0
                            },
                            {
                                label: "Test",
                                data: [8, 20, 15, 40, 20, 50, 25, 35, 20, 28, 25, 30],
                                borderColor: "#10B981",
                                backgroundColor: gradientGreen,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 0
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: (value) => value + "Hr"
                                },
                                grid: { color: "#f1f5f9" }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }
        }))
    });
</script>

</body>
</html>

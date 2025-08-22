<div class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

<div x-data="revenueChart" x-init="renderChart()"
     class="bg-white rounded-2xl shadow-md p-5 w-full max-w-6xl">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Revenue Generate</h2>
        <div class="flex items-center space-x-3 mt-2 sm:mt-0">
        <span class="flex items-center text-sm text-gray-600">
          <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span> Income
        </span>
            <span class="flex items-center text-sm text-gray-600">
          <span class="w-2 h-2 bg-blue-400 rounded-full mr-1"></span> Expense
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
        <canvas id="revenueChartCanvas"></canvas>
    </div>
</div>

<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("revenueChart", () => ({
            renderChart() {
                const ctx = document.getElementById("revenueChartCanvas").getContext("2d");

                new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [
                            {
                                label: "Income",
                                data: [70000, 75000, 60000, 90000, 65000, 67000, 80000, 70000, 75000, 60000, 88000, 68000],
                                backgroundColor: "rgba(59,130,246,0.5)", // light blue
                                stack: "combined",
                                borderRadius: 6
                            },
                            {
                                label: "Expense",
                                data: [40000, 55000, 40000, 47000, 35000, 40000, 46000, 42000, 55000, 40000, 48000, 36000],
                                backgroundColor: "rgba(59,130,246,1)", // dark blue
                                stack: "combined",
                                borderRadius: 6
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
                                    callback: (value) => "$" + value / 1000 + "k"
                                },
                                grid: { color: "#f1f5f9" }
                            },
                            x: {
                                stacked: true,
                                grid: { display: false }
                            }
                        }
                    }
                });
            }
        }))
    });
</script>

</div>

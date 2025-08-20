<div class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div x-data="studyStats()" x-init="initChart()" class="w-full max-w-4xl bg-white rounded-2xl shadow p-5">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
            <h2 class="text-xl font-bold text-gray-900">Study Statistics</h2>

            <!-- Dropdown -->
            <div class="relative mt-2 sm:mt-0">
                <button @click="open = !open"
                        class="flex items-center justify-between w-28 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 hover:bg-gray-100">
                    <span x-text="selected"></span>
                    <!-- Heroicon: chevron-down -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div x-show="open" @click.away="open=false"
                     class="absolute right-0 mt-2 w-28 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                    <ul class="text-sm text-gray-700">
                        <li><button @click="select('Yearly')" class="w-full text-left px-3 py-2 hover:bg-gray-100">Yearly</button></li>
                        <li><button @click="select('Monthly')" class="w-full text-left px-3 py-2 hover:bg-gray-100">Monthly</button></li>
                        <li><button @click="select('Weekly')" class="w-full text-left px-3 py-2 hover:bg-gray-100">Weekly</button></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Legend -->
        <div class="flex items-center gap-4 mb-4">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                <span class="text-sm">Study</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-green-400"></span>
                <span class="text-sm">Test</span>
            </div>
        </div>

        <!-- Chart -->
        <div class="w-full">
            <canvas id="studyChart" class="w-full"></canvas>
        </div>
    </div>

    <script>
        function studyStats() {
            return {
                open: false,
                selected: 'Yearly',
                chart: null,
                data: {
                    labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                    datasets: [
                        {
                            label: "Study",
                            data: [8,12,9,20,11,32,14,22,9,18,10,15],
                            fill: true,
                            backgroundColor: "rgba(59,130,246,0.2)", // blue-500
                            borderColor: "rgba(59,130,246,1)",
                            tension: 0.4
                        },
                        {
                            label: "Test",
                            data: [10,22,18,38,19,45,21,35,17,29,20,27],
                            fill: true,
                            backgroundColor: "rgba(16,185,129,0.2)", // green-400
                            borderColor: "rgba(16,185,129,1)",
                            tension: 0.4
                        }
                    ]
                },
                initChart() {
                    const ctx = document.getElementById('studyChart').getContext('2d');
                    this.chart = new Chart(ctx, {
                        type: 'line',
                        data: this.data,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: { mode: 'index', intersect: false }
                            },
                            scales: {
                                x: {
                                    grid: { display: false }
                                },
                                y: {
                                    ticks: {
                                        callback: function(value) { return value + "Hr"; }
                                    },
                                    grid: { color: "#e5e7eb" }
                                }
                            }
                        }
                    });
                },
                select(option) {
                    this.selected = option;
                    this.open = false;
                    // You can add filtering logic here
                }
            }
        }
    </script>

</div>

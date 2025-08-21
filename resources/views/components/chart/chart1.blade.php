<div class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div x-data="studentAnalytics()" x-init="initChart()" class="w-full max-w-6xl bg-white rounded-2xl shadow-lg p-6 space-y-6">

        <!-- 🔹 Small Analytical Dashboard (Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Card 1 -->
            <div class="bg-blue-50 p-5 rounded-xl flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Enrolled Students</p>
                    <h2 class="text-2xl font-bold text-gray-800">1,245</h2>
                </div>
                <div class="bg-blue-500 text-white p-3 rounded-full">
                    <!-- Heroicon: User Group -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m0 0a4 4 0 018 0m-8 0a4 4 0 00-3-3.87M15 11a4 4 0 10-8 0 4 4 0 008 0z" />
                    </svg>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-green-50 p-5 rounded-xl flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Completed Courses</p>
                    <h2 class="text-2xl font-bold text-gray-800">890</h2>
                </div>
                <div class="bg-green-500 text-white p-3 rounded-full">
                    <!-- Heroicon: Check Badge -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-purple-50 p-5 rounded-xl flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Ongoing Courses</p>
                    <h2 class="text-2xl font-bold text-gray-800">320</h2>
                </div>
                <div class="bg-purple-500 text-white p-3 rounded-full">
                    <!-- Heroicon: Academic Cap -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m-9-11v6a9 9 0 0018 0v-6" />
                    </svg>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-yellow-50 p-5 rounded-xl flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Avg Attendance</p>
                    <h2 class="text-2xl font-bold text-gray-800">96%</h2>
                </div>
                <div class="bg-yellow-500 text-white p-3 rounded-full">
                    <!-- Heroicon: Chart Bar -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 17v-6h2v6H9zm4 0V7h2v10h-2zm4 0v-4h2v4h-2zM5 17v-2h2v2H5z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- 🔹 Analytics Chart Section -->
        <div>
            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <!-- Heroicon: Chart Bar -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 17v-6h2v6H9zm4 0V7h2v10h-2zm4 0v-4h2v4h-2zM5 17v-2h2v2H5z" />
                    </svg>
                    Student Performance Analytics
                </h2>

                <!-- Dropdown -->
                <div class="relative mt-3 sm:mt-0">
                    <button @click="open=!open"
                            class="flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 hover:bg-gray-100">
                        <span x-text="selected"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" @click.away="open=false"
                         class="absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-lg shadow-lg z-20">
                        <ul class="text-sm text-gray-700">
                            <li><button @click="select('Yearly')" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Yearly</button></li>
                            <li><button @click="select('Monthly')" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Monthly</button></li>
                            <li><button @click="select('Weekly')" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Weekly</button></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Legend -->
            <div class="flex flex-wrap gap-4 mb-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                    <span class="text-sm">Assignments</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-green-500"></span>
                    <span class="text-sm">Exams</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-purple-500"></span>
                    <span class="text-sm">Attendance</span>
                </div>
            </div>

            <!-- Chart -->
            <div class="relative h-80">
                <canvas id="analyticsChart" class="w-full"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    function studentAnalytics() {
        return {
            open: false,
            selected: 'Monthly',
            chart: null,
            initChart() {
                const ctx = document.getElementById('analyticsChart').getContext('2d');
                this.chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                        datasets: [
                            {
                                label: "Assignments",
                                data: [85, 90, 78, 88, 92, 95],
                                backgroundColor: "rgba(59,130,246,0.7)" // blue-500
                            },
                            {
                                label: "Exams",
                                data: [75, 80, 70, 85, 88, 90],
                                backgroundColor: "rgba(34,197,94,0.7)" // green-500
                            },
                            {
                                label: "Attendance",
                                data: [95, 97, 93, 96, 98, 99],
                                backgroundColor: "rgba(168,85,247,0.7)" // purple-500
                            }
                        ]
                    },
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
                                beginAtZero: true,
                                grid: { color: "#e5e7eb" },
                                ticks: { callback: (val) => val + "%" }
                            }
                        }
                    }
                });
            },
            select(option) {
                this.selected = option;
                this.open = false;
                // add dynamic filtering if needed
            }
        }
    }
</script>

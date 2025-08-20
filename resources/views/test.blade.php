
<x-layouts.main>

    <!-- Dashboard Cards Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col justify-between min-h-[220px]">

            <!-- Top: Number + Text -->
            <div>
                <h2 class="text-2xl font-bold">155+</h2>
                <p class="text-gray-600 text-sm mt-4">Completed Courses</p>
            </div>

            <!-- Bottom: Icon Left + Chart Right -->
            <div class="flex items-center justify-between mt-6">

                <!-- Icon -->
                <div class="bg-blue-500 text-white p-3 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6c-2.21-1.22-4.55-2-7-2v14c2.45
                                 0 4.79.78 7 2m0-14c2.21-1.22
                                 4.55-2 7-2v14c-2.45
                                 0-4.79.78-7 2m0-14v14" />
                    </svg>
                </div>

                <!-- Chart -->
                <div class="w-28 h-16">
                    <svg viewBox="0 0 100 40" class="w-full h-full text-teal-400">
                        <defs>
                            <linearGradient id="lineGradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="currentColor" stop-opacity="0.8"/>
                                <stop offset="100%" stop-color="currentColor" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <polyline fill="none" stroke="currentColor" stroke-width="2"
                                  points="0,35 20,25 40,28 60,18 80,22 100,10" />
                        <polygon fill="url(#lineGradient)"
                                 points="0,40 0,35 20,25 40,28 60,18 80,22 100,10 100,40"/>
                    </svg>
                </div>
            </div>

        </div>

    </div>

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


    <div class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <!-- Course Card -->
    <div class="max-w-sm w-full bg-white rounded-2xl shadow p-4 flex flex-col">

        <!-- Top Image -->
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=400&fit=crop" alt="Course Image"
             class="w-full h-40 object-cover rounded-lg mb-4">

        <!-- Tag -->
        <span class="inline-block px-3 py-1 text-sm rounded-full bg-green-100 text-green-600 font-medium mb-2">
      Development
    </span>

        <!-- Title -->
        <h2 class="text-lg font-bold text-gray-800 mb-2">
            Full Stack Web Development
        </h2>

        <!-- Creator -->
        <div class="flex items-center gap-2 mb-3">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Creator"
                 class="w-8 h-8 rounded-full">
            <p class="text-sm text-gray-600">
                Created by <span class="font-semibold text-gray-800">Albert James</span>
            </p>
        </div>

        <!-- Lessons & Hours -->
        <div class="flex items-center justify-between text-sm text-gray-600 border-t border-b py-2 mb-3">
            <div class="flex items-center gap-1">
                <!-- Heroicon: Video Camera -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M4 6h8a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z" />
                </svg>
                24 Lessons
            </div>
            <div class="flex items-center gap-1">
                <!-- Heroicon: Clock -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                40 Hours
            </div>
        </div>

        <!-- Rating + Button -->
        <div class="flex items-center justify-between">
            <div class="flex items-center text-sm text-gray-700">
                <!-- Heroicon: Star -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.356 4.177a1 1 0 00.95.69h4.393c.969 0 1.371 1.24.588 1.81l-3.562 2.585a1 1 0 00-.364 1.118l1.357 4.177c.3.921-.755 1.688-1.54 1.118l-3.562-2.585a1 1 0 00-1.175 0l-3.562 2.585c-.785.57-1.84-.197-1.54-1.118l1.357-4.177a1 1 0 00-.364-1.118L2.11 9.604c-.783-.57-.38-1.81.588-1.81h4.393a1 1 0 00.95-.69l1.008-3.177z" />
                </svg>
                <span class="ml-1 font-medium">4.9</span>
                <span class="ml-1 text-gray-500">(12k)</span>
            </div>
            <button class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded-full hover:bg-blue-50 transition">
                View Details
            </button>
        </div>
    </div>

    </div>

</x-layouts.main>

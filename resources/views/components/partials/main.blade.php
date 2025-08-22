<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <title>Analytics Dashboard (Students & Mentors)</title>

    <!-- Tailwind (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* hide x-cloak until Alpine initializes */
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

<!-- App root -->
<div x-data="app()" x-init="init()" x-cloak class="min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-4">
                    <!-- Logo -->
                    <!-- Nav Links -->
                    <div class="hidden sm:flex items-center gap-2">
                        <button @click="openDashboard()"
                                :class="view==='dashboard'? 'text-indigo-600 font-semibold' : 'text-gray-600'"
                                class="px-3 py-2 rounded-md inline-flex items-center gap-2">
                            <!-- Heroicon: chart-bar -->
                            <div class="bg-indigo-600 text-white rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"/>
                            </svg>
                            </div>
                            <span class="font-semibold">Edulearn</span>
                        </button>
                    </div>
                </div>

                <!-- Right side (mobile menu placeholder / profile) -->
            </div>
        </div>
    </nav>

    <!-- MAIN -->
    <main class="max-w-7xl mx-auto p-4">

        <!-- HOME VIEW (simple call-to-action) -->

        <!-- DASHBOARD VIEW -->
        <section x-show="view==='dashboard'" x-transition class="space-y-6">

            <!-- === STUDENT ANALYTICS: KPI CARDS === -->
            <div id="student" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Card: Enrolled -->
                <div class="bg-white rounded-2xl shadow p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Enrolled Students</p>
                        <h3 class="text-2xl font-bold">1,245</h3>
                    </div>
                    <div class="bg-indigo-500 p-3 rounded-full text-white">
                        <!-- Heroicon: user-group -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-3.13a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Card: Completed Courses -->
                <div class="bg-white rounded-2xl shadow p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Completed Courses</p>
                        <h3 class="text-2xl font-bold">890</h3>
                    </div>
                    <div class="bg-emerald-500 p-3 rounded-full text-white">
                        <!-- Heroicon: check-badge -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4M7 7h.01M7 11h.01M7 15h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Card: Ongoing -->
                <div class="bg-white rounded-2xl shadow p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Ongoing Courses</p>
                        <h3 class="text-2xl font-bold">320</h3>
                    </div>
                    <div class="bg-purple-500 p-3 rounded-full text-white">
                        <!-- Heroicon: academic-cap -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"/>
                        </svg>
                    </div>
                </div>

                <!-- Card: Avg Attendance -->
                <div class="bg-white rounded-2xl shadow p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Avg Attendance</p>
                        <h3 class="text-2xl font-bold">96%</h3>
                    </div>
                    <div class="bg-yellow-500 p-3 rounded-full text-white">
                        <!-- Heroicon: chart-bar -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3v18h18M9 17v-6h2v6H9zm4 0V7h2v10h-2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- STUDENT CHART CARD -->
            <div class="bg-white rounded-2xl shadow p-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-indigo-100 p-2 rounded-md">
                            <!-- Heroicon: presentation-chart-bar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 3v13M20 21H4M4 7h16"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Student Performance</h3>
                            <p class="text-sm text-gray-500">Assignments · Exams · Attendance</p>
                        </div>
                    </div>

                    <!-- timeframe dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                                class="px-3 py-2 border rounded-md bg-gray-50 text-sm flex items-center gap-2">
                            <span x-text="studentRange"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-36 bg-white border rounded-md shadow z-10">
                            <button @click="updateStudentRange('Yearly'); open=false"
                                    class="block w-full text-left px-3 py-2 hover:bg-gray-50 text-sm">Yearly
                            </button>
                            <button @click="updateStudentRange('Monthly'); open=false"
                                    class="block w-full text-left px-3 py-2 hover:bg-gray-50 text-sm">Monthly
                            </button>
                            <button @click="updateStudentRange('Weekly'); open=false"
                                    class="block w-full text-left px-3 py-2 hover:bg-gray-50 text-sm">Weekly
                            </button>
                        </div>
                    </div>
                </div>

                <div class="relative h-64">
                    <canvas id="studentChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- ===== MENTOR ANALYTICS ===== -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Mentor: Total -->
                <div class="bg-white rounded-2xl shadow p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Mentors</p>
                        <h3 class="text-2xl font-bold">120</h3>
                    </div>
                    <div class="bg-sky-500 p-3 rounded-full text-white">
                        <!-- Heroicon: user -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5.121 17.804A10.97 10.97 0 0112 15c2.5 0 4.79.77 6.879 2.104M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Mentor: Active -->
                <div class="bg-white rounded-2xl shadow p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Active Mentors</p>
                        <h3 class="text-2xl font-bold">45</h3>
                    </div>
                    <div class="bg-emerald-500 p-3 rounded-full text-white">
                        <!-- Heroicon: lightning-bolt -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>

                <!-- Mentor: Avg Rating -->
                <div class="bg-white rounded-2xl shadow p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Avg Rating</p>
                        <h3 class="text-2xl font-bold">4.7</h3>
                    </div>
                    <div class="bg-yellow-500 p-3 rounded-full text-white">
                        <!-- Heroicon: star -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.37 2.449a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.449a1 1 0 00-1.175 0l-3.37 2.449c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.07 9.382c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.955z"/>
                        </svg>
                    </div>
                </div>

                <!-- Mentor: Followers -->
                <div class="bg-white rounded-2xl shadow p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Followers</p>
                        <h3 class="text-2xl font-bold">12k</h3>
                    </div>
                    <div class="bg-indigo-500 p-3 rounded-full text-white">
                        <!-- Heroicon: heart -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- MENTOR CHART -->
            <div class="bg-white rounded-2xl shadow p-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-sky-100 p-2 rounded-md">
                            <!-- Heroicon: users -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-sky-600" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-3.13a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Mentor Activity</h3>
                            <p class="text-sm text-gray-500">Sessions · Response Time · Ratings</p>
                        </div>
                    </div>

                    <!-- timeframe dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                                class="px-3 py-2 border rounded-md bg-gray-50 text-sm flex items-center gap-2">
                            <span x-text="mentorRange"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open=false" x-transition
                             class="absolute right-0 mt-2 w-36 bg-white border rounded-md shadow z-10">
                            <button @click="updateMentorRange('Yearly'); open=false"
                                    class="block w-full text-left px-3 py-2 hover:bg-gray-50 text-sm">Yearly
                            </button>
                            <button @click="updateMentorRange('Monthly'); open=false"
                                    class="block w-full text-left px-3 py-2 hover:bg-gray-50 text-sm">Monthly
                            </button>
                            <button @click="updateMentorRange('Weekly'); open=false"
                                    class="block w-full text-left px-3 py-2 hover:bg-gray-50 text-sm">Weekly
                            </button>
                        </div>
                    </div>
                </div>

                <div class="relative h-64">
                    <canvas id="mentorChart" class="w-full h-full"></canvas>
                </div>
            </div>

        </section>
    </main>
</div>

<!-- Alpine + Chart logic -->
<script>
    function app() {
        return {
            view: 'home',
            studentChart: null,
            mentorChart: null,
            studentChartInited: false,
            mentorChartInited: false,
            studentRange: 'Monthly',
            mentorRange: 'Monthly',

            init() { /* nothing on load; charts init when opening dashboard */
            },

            openDashboard() {
                this.view = 'dashboard';
                // init charts once after DOM updated
                this.$nextTick(() => {
                    if (!this.studentChartInited) this.initStudentChart();
                    if (!this.mentorChartInited) this.initMentorChart();
                });
                // small scroll to top of dashboard
                window.scrollTo({top: 0, behavior: 'smooth'});
            },

            scrollToSection(id) {
                const el = document.getElementById(id);
                if (el) el.scrollIntoView({behavior: 'smooth', block: 'start'});
            },

            // ---------- STUDENT CHART ----------
            initStudentChart() {
                const ctx = document.getElementById('studentChart').getContext('2d');
                const data = this.studentDataFor('Monthly');
                this.studentChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {label: 'Assignments', data: data.assignments, backgroundColor: 'rgba(59,130,246,0.8)'}, // blue
                            {label: 'Exams', data: data.exams, backgroundColor: 'rgba(34,197,94,0.8)'}, // green
                            {label: 'Attendance', data: data.attendance, backgroundColor: 'rgba(168,85,247,0.8)'} // purple
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {legend: {display: true}, tooltip: {mode: 'index', intersect: false}},
                        scales: {
                            x: {grid: {display: false}},
                            y: {
                                beginAtZero: true,
                                grid: {color: '#eef2f7'},
                                ticks: {callback: v => v + (v > 1 ? '%' : '')}
                            }
                        }
                    }
                });
                this.studentChartInited = true;
            },

            updateStudentRange(range) {
                this.studentRange = range;
                if (!this.studentChart) return;
                const d = this.studentDataFor(range);
                this.studentChart.data.labels = d.labels;
                this.studentChart.data.datasets[0].data = d.assignments;
                this.studentChart.data.datasets[1].data = d.exams;
                this.studentChart.data.datasets[2].data = d.attendance;
                this.studentChart.update();
            },

            studentDataFor(range) {
                if (range === 'Weekly') {
                    return {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        assignments: [12, 15, 10, 18, 14, 9, 7],
                        exams: [3, 2, 1, 4, 3, 1, 0],
                        attendance: [95, 92, 94, 96, 97, 88, 85]
                    }
                } else if (range === 'Yearly') {
                    return {
                        labels: ['2020', '2021', '2022', '2023', '2024', '2025'],
                        assignments: [800, 900, 950, 1100, 1200, 1250],
                        exams: [320, 350, 370, 400, 420, 450],
                        attendance: [88, 90, 91, 92, 94, 95]
                    }
                } else { // Monthly (default)
                    return {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        assignments: [85, 90, 78, 88, 92, 95],
                        exams: [75, 80, 70, 85, 88, 90],
                        attendance: [95, 97, 93, 96, 98, 99]
                    }
                }
            },

            // ---------- MENTOR CHART ----------
            initMentorChart() {
                const ctx = document.getElementById('mentorChart').getContext('2d');
                const d = this.mentorDataFor('Monthly');
                this.mentorChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: d.labels,
                        datasets: [
                            {
                                label: 'Sessions',
                                data: d.sessions,
                                fill: true,
                                backgroundColor: 'rgba(14,165,233,0.15)',
                                borderColor: 'rgba(14,165,233,1)',
                                tension: 0.4
                            },
                            {
                                label: 'Avg Rating',
                                data: d.ratings,
                                fill: true,
                                backgroundColor: 'rgba(249,115,22,0.12)',
                                borderColor: 'rgba(249,115,22,1)',
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {legend: {display: true}, tooltip: {mode: 'index', intersect: false}},
                        scales: {
                            x: {grid: {display: false}},
                            y: {grid: {color: '#eef2f7'}, beginAtZero: true}
                        }
                    }
                });
                this.mentorChartInited = true;
            },

            updateMentorRange(range) {
                this.mentorRange = range;
                if (!this.mentorChart) return;
                const d = this.mentorDataFor(range);
                this.mentorChart.data.labels = d.labels;
                this.mentorChart.data.datasets[0].data = d.sessions;
                this.mentorChart.data.datasets[1].data = d.ratings;
                this.mentorChart.update();
            },

            mentorDataFor(range) {
                if (range === 'Weekly') {
                    return {
                        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        sessions: [12, 18, 9, 22, 14, 10, 6],
                        ratings: [4.6, 4.7, 4.6, 4.8, 4.7, 4.5, 4.4]
                    }
                } else if (range === 'Yearly') {
                    return {
                        labels: ['2020', '2021', '2022', '2023', '2024', '2025'],
                        sessions: [1200, 1400, 1500, 1700, 1900, 2100],
                        ratings: [4.3, 4.4, 4.5, 4.6, 4.7, 4.7]
                    }
                } else { // Monthly
                    return {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        sessions: [120, 150, 110, 180, 200, 220],
                        ratings: [4.5, 4.6, 4.6, 4.7, 4.7, 4.8]
                    }
                }
            }
        }
    }
</script>

</body>
</html>


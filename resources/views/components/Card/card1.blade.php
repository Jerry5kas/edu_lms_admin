<div class="bg-gray-50 p-6" x-data="{ stats: [
    { number: '155+', label: 'Completed Courses', icon: 'book-open', color: 'bg-blue-500', chart: '0,35 20,25 40,28 60,18 80,22 100,10' },
    { number: '8', label: 'Active Courses', icon: 'play', color: 'bg-green-500', chart: '0,30 20,28 40,20 60,25 80,15 100,18' },
    { number: '12', label: 'Certificates Earned', icon: 'academic-cap', color: 'bg-purple-500', chart: '0,28 20,22 40,30 60,18 80,25 100,12' },
    { number: '540+', label: 'Learning Hours', icon: 'clock', color: 'bg-orange-500', chart: '0,32 20,26 40,22 60,20 80,18 100,16' }
] }">

    <!-- Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Card -->
        <template x-for="stat in stats" :key="stat.label">
            <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col justify-between min-h-[220px] transition hover:shadow-lg">

                <!-- Top -->
                <div>
                    <h2 class="text-2xl font-bold" x-text="stat.number"></h2>
                    <p class="text-gray-600 text-sm mt-4" x-text="stat.label"></p>
                </div>

                <!-- Bottom -->
                <div class="flex items-center justify-between mt-6">

                    <!-- Icon -->
                    <div :class="`${stat.color} text-white p-3 rounded-full flex items-center justify-center`">

                        <!-- Dynamic Heroicons -->
                        <template x-if="stat.icon === 'book-open'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M12 6c-2.21-1.22-4.55-2-7-2v14c2.45
                         0 4.79.78 7 2m0-14c2.21-1.22
                         4.55-2 7-2v14c-2.45
                         0-4.79.78-7 2m0-14v14" />
                            </svg>
                        </template>

                        <template x-if="stat.icon === 'play'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M5.25 5.653c0-.856.917-1.398 1.667-.931l11.25 6.848a1.125 1.125 0 010 1.931L6.917 20.349A1.125 1.125 0 015.25 19.418V5.653z" />
                            </svg>
                        </template>

                        <template x-if="stat.icon === 'academic-cap'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0 0c-3 0-5.5-1.5-7-4m7 4c3 0 5.5-1.5 7-4" />
                            </svg>
                        </template>

                        <template x-if="stat.icon === 'clock'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                    </div>

                    <!-- Mini Chart -->
                    <div class="w-28 h-16">
                        <svg viewBox="0 0 100 40" class="w-full h-full text-teal-400">
                            <defs>
                                <linearGradient id="lineGradient" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="currentColor" stop-opacity="0.8"/>
                                    <stop offset="100%" stop-color="currentColor" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                            <polyline fill="none" stroke="currentColor" stroke-width="2"
                                      :points="stat.chart"/>
                            <polygon fill="url(#lineGradient)"
                                     :points="`0,40 ${stat.chart} 100,40`"/>
                        </svg>
                    </div>
                </div>

            </div>
        </template>
    </div>
</div>

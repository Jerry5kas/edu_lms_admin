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

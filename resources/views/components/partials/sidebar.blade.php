<div class="min-h-screen" x-data="{ open: false }">
<!-- Mobile overlay -->
<div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden" @click="open=false"></div>

<!-- Sidebar -->

    <aside
        class="fixed z-50 lg:z-0 inset-y-0 left-0 w-64 bg-white shadow-md lg:static transform transition-transform duration-200 ease-in-out min-h-screen"
        :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        <!-- Logo -->
        <div class="flex items-center px-6 py-4 border-b">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2l9 4.5v3c0 5.25-3.75 10.5-9 12-5.25-1.5-9-6.75-9-12v-3L12 2z" />
            </svg>
            <span class="ml-2 font-bold text-xl">Edmate</span>
        </div>

        <!-- Nav -->
        <nav class="px-4 py-6 space-y-2 text-gray-700 text-sm">

            <!-- Dashboard -->
            <div>
                <a href="{{ route('dashboard.index') }}"
                   class="flex items-center w-full px-3 py-2 rounded-lg hover:bg-blue-50 text-blue-600 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m-4 4h12a2 2 0 002-2V10a2 2 0 00-.586-1.414l-7-7a2 2 0 00-2.828 0l-7 7A2 2 0 003 10v10a2 2 0 002 2z"/>
                    </svg>
                    Dashboard
                </a>
            </div>

            <!-- Courses Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="flex items-center w-full px-3 py-2 rounded-lg hover:bg-blue-50 text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <svg class="h-5 w-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 14l6.16-3.422A12.083 12.083 0 0112 20.944a12.083 12.083 0 01-6.16-10.366L12 14z"/>
                    </svg>
                    Courses
                    <svg :class="open ? 'rotate-180' : 'rotate-0'"
                         class="h-4 w-4 ml-auto transform transition-transform text-gray-500"
                         xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute left-0 mt-2 w-56 rounded-lg shadow-lg bg-white border border-gray-100 z-20">
                    <div class="py-2">
                        <a href="{{ route('dashboard.courses.student.index') }}"
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                            <svg class="h-5 w-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0v.75H4.5v-.75z"/>
                            </svg>
                            Student Courses
                        </a>

                        <a href="{{ route('dashboard.courses.master.index') }}"
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                            <svg class="h-5 w-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0v.75H4.5v-.75z"/>
                            </svg>
                          Instructor Courses
                        </a>
                    </div>
                </div>
            </div>

            <!-- Other Nav Links (no changes) -->
            <a href="#" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a4 4 0 00-5-4V4a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h8"/>
                </svg>
                Students
            </a>

            <!-- keep your other links exactly the same as before... --><a href="#" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12h6m2 0a2 2 0 100-4H7a2 2 0 100 4h10zm-6 8v-6m0 6H9a2 2 0 01-2-2v-4h10v4a2 2 0 01-2 2h-2z" />
                </svg>
                Assignments
            </a>

            <a href="#" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a4 4 0 00-5-4V4a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h8" />
                </svg>
                Mentors
            </a>

            <a href="#" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 17v-2h6v2H9zm-4 4h14v-2H5v2zm0-4h14v-2H5v2z" />
                </svg>
                Resources
            </a>

            <a href="#" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M8 10h.01M12 14h.01M16 10h.01M21 16v-2a9 9 0 10-18 0v2a3 3 0 003 3h12a3 3 0 003-3z" />
                </svg>
                Messages
            </a>

            <a href="#" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M11 11V7a4 4 0 118 0v4m-4 4h-1a3 3 0 00-3 3v4h8v-4a3 3 0 00-3-3h-1z" />
                </svg>
                Analytics
            </a>

            <a href="#" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M8 17l4 4 4-4m0-5a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Events
            </a>

            <a href="#" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 20h9M3 20h9m0 0V4" />
                </svg>
                Library
            </a>

            <a href="#" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8c-1.105 0-2 .895-2 2s.895 2 2 2a2 2 0 100-4z" />
                    <path d="M12 14v6" />
                </svg>
                Pricing
            </a>

            <!-- Divider -->
            <div class="border-t my-4"></div>

            <!-- Settings -->
            <a href="#" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 6v6l4 2" />
                </svg>
                Account Settings
            </a>

            <a href="#" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
                Authentication
            </a>
        </nav>



        <!-- Upgrade Box -->
        <div class="px-4 py-6 mt-auto">
            <div class="bg-blue-50 rounded-xl p-4 text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="icon" class="h-12 mx-auto mb-2">
                <p class="text-xs text-gray-600">Get Pro Certificate <br> Explore 400+ courses with lifetime members</p>
                <button class="mt-3 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg">Get Access</button>
            </div>
        </div>

    </aside>
</div>

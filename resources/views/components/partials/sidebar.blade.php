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
        <nav class=" min-h-screen px-4 py-6 space-y-2 text-gray-700 text-sm">

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
            <div>
                <a href="{{ route('categories.index') }}"
                   class="flex items-center w-full px-3 py-2 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m-4 4h12a2 2 0 002-2V10a2 2 0 00-.586-1.414l-7-7a2 2 0 00-2.828 0l-7 7A2 2 0 003 10v10a2 2 0 002 2z"/>
                    </svg>
                    Categories
                </a>
            </div>
            <div>
                <a href="{{ route('tags.index') }}"
                   class="flex items-center w-full px-3 py-2 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Tags
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
                        <a href="{{ route('courses.index') }}"
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                            <svg class="h-5 w-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0v.75H4.5v-.75z"/>
                            </svg>
                            All Courses
                        </a>

                        <a href="{{ route('instructor.courses.index') }}"
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                            <svg class="h-5 w-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0v.75H4.5v-.75z"/>
                            </svg>
                            Instructor Courses
                        </a>

                        <div class="border-t border-gray-200 my-1"></div>

                        <a href="{{ route('courses.index') }}"
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 text-gray-500">
                            <svg class="h-5 w-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            Course Sections
                            <span class="ml-auto text-xs text-gray-400">(via course)</span>
                        </a>

                        <a href="{{ route('courses.index') }}"
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 text-gray-500">
                            <svg class="h-5 w-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Lessons
                            <span class="ml-auto text-xs text-gray-400">(via section)</span>
                        </a>

                        <a href="{{ route('lesson-views.index') }}"
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 text-gray-500">
                            <svg class="h-5 w-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Lesson Views
                            <span class="ml-auto text-xs text-gray-400">(progress tracking)</span>
                        </a>

                        <a href="{{ route('lesson-tracking.example') }}"
                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 text-gray-500">
                            <svg class="h-5 w-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Integration Guide
                            <span class="ml-auto text-xs text-gray-400">(API docs)</span>
                        </a>

{{--                        <a href="{{ route('quizzes.index') }}"--}}
{{--                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 text-gray-500">--}}
{{--                            <svg class="h-5 w-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg"--}}
{{--                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>--}}
{{--                            </svg>--}}
{{--                            Quizzes--}}
{{--                            <span class="ml-auto text-xs text-gray-400">(assessment)</span>--}}
{{--                        </a>--}}

{{--                        <a href="{{ route('media.index') }}"--}}
{{--                           class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50 text-gray-500">--}}
{{--                            <svg class="h-5 w-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg"--}}
{{--                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>--}}
{{--                            </svg>--}}
{{--                            Media Library--}}
{{--                            <span class="ml-auto text-xs text-gray-400">(files)</span>--}}
{{--                        </a>--}}
                    </div>
                </div>
            </div>

            <a href="{{ route('quizzes.index') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Quizzes
            </a>

            <a href="{{ route('media.index') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Media Library
            </a>
            <a href="{{ route('payments.index') }}"
               class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.105 0-2 .895-2 2s.895 2 2 2a2 2 0 100-4zM4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Payments
            </a>
            <a href="{{ route('subscriptions.index')}}" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a4 4 0 00-5-4V4a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h8"/>
                </svg>
                Subscription
            </a>

            <!-- Other Nav Links (no changes) -->
            <a href="/notifications" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a4 4 0 00-5-4V4a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h8"/>
                </svg>
              notification
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

            <!-- Profile -->
            <a href="{{ route('auth.profile.edit') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profile
            </a>

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

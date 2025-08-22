{{--@extends('components.layouts.main')--}}

{{--@section('content')--}}
{{--    <h1 class="text-2xl font-bold mb-6">Mentor Courses</h1>--}}
{{--@endsection--}}

<x-layouts.main>
    <div class="bg-gray-100 p-6" x-data="{ page: 1, totalPages: 3 }">

        <!-- Grid Container -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            <!-- Mentor Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition hover:shadow-2xl" x-data="{ followed: false }">

                <!-- Background Image -->
                <div class="relative">
                    <img class="w-full h-40 object-cover"
                         src="https://images.unsplash.com/photo-1513258496099-48168024aec0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=60"
                         alt="mentor background">

                    <!-- Follow Button -->
                    <button @click="followed = !followed"
                            class="absolute top-3 right-3 bg-white/80 backdrop-blur-md text-gray-800 text-sm px-3 py-1 rounded-full shadow hover:bg-indigo-500 hover:text-white transition">
                        <span x-text="followed ? 'Following' : 'Follow'"></span>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <!-- Profile -->
                    <div class="flex items-center gap-3">
                        <img class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500"
                             src="https://randomuser.me/api/portraits/women/44.jpg"
                             alt="profile">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Maria Prova</h3>
                            <p class="text-sm text-indigo-600">Content Writer</p>
                        </div>
                    </div>

                    <!-- Bio -->
                    <p class="mt-3 text-sm text-gray-600">
                        Hi, I am Maria, a doctoral student at Oxford University majoring in UI/UX.
                        I have been working for 2 years in a local company.
                    </p>

                    <!-- Footer Info -->
                    <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center gap-1">
                            <!-- Heroicon: Clipboard List -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-1 1H5a2 2 0 00-2 2v11a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2h-3a1 1 0 00-1-1H9zM7 7a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                            <span>45 Tasks</span>
                        </div>

                        <div class="flex items-center gap-1">
                            <!-- Heroicon: Star -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.37 2.449a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.449a1 1 0 00-1.175 0l-3.37 2.449c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.07 9.382c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.955z"/>
                            </svg>
                            <span>4.8 (750 Reviews)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Duplicate Mentor Cards as needed -->
            <!-- Mentor Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition hover:shadow-2xl" x-data="{ followed: false }">

                <!-- Background Image -->
                <div class="relative">
                    <img class="w-full h-40 object-cover"
                         src="https://images.unsplash.com/photo-1513258496099-48168024aec0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=60"
                         alt="mentor background">

                    <!-- Follow Button -->
                    <button @click="followed = !followed"
                            class="absolute top-3 right-3 bg-white/80 backdrop-blur-md text-gray-800 text-sm px-3 py-1 rounded-full shadow hover:bg-indigo-500 hover:text-white transition">
                        <span x-text="followed ? 'Following' : 'Follow'"></span>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <!-- Profile -->
                    <div class="flex items-center gap-3">
                        <img class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500"
                             src="https://randomuser.me/api/portraits/women/44.jpg"
                             alt="profile">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Maria Prova</h3>
                            <p class="text-sm text-indigo-600">Content Writer</p>
                        </div>
                    </div>

                    <!-- Bio -->
                    <p class="mt-3 text-sm text-gray-600">
                        Hi, I am Maria, a doctoral student at Oxford University majoring in UI/UX.
                        I have been working for 2 years in a local company.
                    </p>

                    <!-- Footer Info -->
                    <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center gap-1">
                            <!-- Heroicon: Clipboard List -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-1 1H5a2 2 0 00-2 2v11a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2h-3a1 1 0 00-1-1H9zM7 7a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                            <span>45 Tasks</span>
                        </div>

                        <div class="flex items-center gap-1">
                            <!-- Heroicon: Star -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.37 2.449a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.449a1 1 0 00-1.175 0l-3.37 2.449c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.07 9.382c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.955z"/>
                            </svg>
                            <span>4.8 (750 Reviews)</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Mentor Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition hover:shadow-2xl" x-data="{ followed: false }">

                <!-- Background Image -->
                <div class="relative">
                    <img class="w-full h-40 object-cover"
                         src="https://images.unsplash.com/photo-1513258496099-48168024aec0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=60"
                         alt="mentor background">

                    <!-- Follow Button -->
                    <button @click="followed = !followed"
                            class="absolute top-3 right-3 bg-white/80 backdrop-blur-md text-gray-800 text-sm px-3 py-1 rounded-full shadow hover:bg-indigo-500 hover:text-white transition">
                        <span x-text="followed ? 'Following' : 'Follow'"></span>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <!-- Profile -->
                    <div class="flex items-center gap-3">
                        <img class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500"
                             src="https://randomuser.me/api/portraits/women/44.jpg"
                             alt="profile">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Maria Prova</h3>
                            <p class="text-sm text-indigo-600">Content Writer</p>
                        </div>
                    </div>

                    <!-- Bio -->
                    <p class="mt-3 text-sm text-gray-600">
                        Hi, I am Maria, a doctoral student at Oxford University majoring in UI/UX.
                        I have been working for 2 years in a local company.
                    </p>

                    <!-- Footer Info -->
                    <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center gap-1">
                            <!-- Heroicon: Clipboard List -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-1 1H5a2 2 0 00-2 2v11a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2h-3a1 1 0 00-1-1H9zM7 7a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                            <span>45 Tasks</span>
                        </div>

                        <div class="flex items-center gap-1">
                            <!-- Heroicon: Star -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.37 2.449a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.449a1 1 0 00-1.175 0l-3.37 2.449c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.07 9.382c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.955z"/>
                            </svg>
                            <span>4.8 (750 Reviews)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mentor Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition hover:shadow-2xl" x-data="{ followed: false }">

                <!-- Background Image -->
                <div class="relative">
                    <img class="w-full h-40 object-cover"
                         src="https://images.unsplash.com/photo-1513258496099-48168024aec0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=60"
                         alt="mentor background">

                    <!-- Follow Button -->
                    <button @click="followed = !followed"
                            class="absolute top-3 right-3 bg-white/80 backdrop-blur-md text-gray-800 text-sm px-3 py-1 rounded-full shadow hover:bg-indigo-500 hover:text-white transition">
                        <span x-text="followed ? 'Following' : 'Follow'"></span>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <!-- Profile -->
                    <div class="flex items-center gap-3">
                        <img class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500"
                             src="https://randomuser.me/api/portraits/women/44.jpg"
                             alt="profile">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Maria Prova</h3>
                            <p class="text-sm text-indigo-600">Content Writer</p>
                        </div>
                    </div>

                    <!-- Bio -->
                    <p class="mt-3 text-sm text-gray-600">
                        Hi, I am Maria, a doctoral student at Oxford University majoring in UI/UX.
                        I have been working for 2 years in a local company.
                    </p>

                    <!-- Footer Info -->
                    <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center gap-1">
                            <!-- Heroicon: Clipboard List -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-1 1H5a2 2 0 00-2 2v11a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2h-3a1 1 0 00-1-1H9zM7 7a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                            <span>45 Tasks</span>
                        </div>

                        <div class="flex items-center gap-1">
                            <!-- Heroicon: Star -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.37 2.449a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.449a1 1 0 00-1.175 0l-3.37 2.449c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.07 9.382c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.955z"/>
                            </svg>
                            <span>4.8 (750 Reviews)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mentor Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition hover:shadow-2xl" x-data="{ followed: false }">

                <!-- Background Image -->
                <div class="relative">
                    <img class="w-full h-40 object-cover"
                         src="https://images.unsplash.com/photo-1513258496099-48168024aec0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=60"
                         alt="mentor background">

                    <!-- Follow Button -->
                    <button @click="followed = !followed"
                            class="absolute top-3 right-3 bg-white/80 backdrop-blur-md text-gray-800 text-sm px-3 py-1 rounded-full shadow hover:bg-indigo-500 hover:text-white transition">
                        <span x-text="followed ? 'Following' : 'Follow'"></span>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <!-- Profile -->
                    <div class="flex items-center gap-3">
                        <img class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500"
                             src="https://randomuser.me/api/portraits/women/44.jpg"
                             alt="profile">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Maria Prova</h3>
                            <p class="text-sm text-indigo-600">Content Writer</p>
                        </div>
                    </div>

                    <!-- Bio -->
                    <p class="mt-3 text-sm text-gray-600">
                        Hi, I am Maria, a doctoral student at Oxford University majoring in UI/UX.
                        I have been working for 2 years in a local company.
                    </p>

                    <!-- Footer Info -->
                    <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                        <div class="flex items-center gap-1">
                            <!-- Heroicon: Clipboard List -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-1 1H5a2 2 0 00-2 2v11a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2h-3a1 1 0 00-1-1H9zM7 7a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                            <span>45 Tasks</span>
                        </div>

                        <div class="flex items-center gap-1">
                            <!-- Heroicon: Star -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.37 2.449a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.449a1 1 0 00-1.175 0l-3.37 2.449c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.07 9.382c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.955z"/>
                            </svg>
                            <span>4.8 (750 Reviews)</span>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- Pagination -->
        <div class="mt-8 flex items-center justify-center gap-2">

            <!-- Previous -->
            <button @click="if(page > 1) page--"
                    :class="page === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-indigo-500 hover:text-white'"
                    class="flex items-center px-3 py-2 bg-white rounded-lg shadow text-gray-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 14.707a1 1 0 01-1.414 0L7.586 11 11.293 7.293a1 1 0 011.414 1.414L10.414 11l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                </svg>
                Prev
            </button>

            <!-- Page Numbers -->
            <template x-for="i in totalPages" :key="i">
                <button @click="page = i"
                        :class="page === i ? 'bg-indigo-500 text-white' : 'bg-white text-gray-700 hover:bg-indigo-100'"
                        class="px-3 py-2 rounded-lg shadow transition">
                    <span x-text="i"></span>
                </button>
            </template>

            <!-- Next -->
            <button @click="if(page < totalPages) page++"
                    :class="page === totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-indigo-500 hover:text-white'"
                    class="flex items-center px-3 py-2 bg-white rounded-lg shadow text-gray-700 transition">
                Next
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 5.293a1 1 0 011.414 0L12.414 9 8.707 12.707a1 1 0 01-1.414-1.414L10.586 9 7.293 6.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    </div>
</x-layouts.main>

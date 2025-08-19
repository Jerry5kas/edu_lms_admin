<nav class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <a href="/" class="text-xl font-bold">MySite</a>

            <!-- Desktop Menu -->
            <ul class="hidden md:flex space-x-6">
                <li><a href="/" class="hover:text-gray-300">Home</a></li>
                <li><a href="/about" class="hover:text-gray-300">About</a></li>
                <li><a href="/contact" class="hover:text-gray-300">Contact</a></li>
            </ul>

            <!-- Mobile Hamburger -->
            <div class="md:hidden" x-data="{ open: false }">
                <button @click="open = !open" class="focus:outline-none">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Mobile Menu -->
                <div x-show="open" @click.away="open = false"
                     class="absolute top-16 right-4 w-48 bg-gray-800 rounded-lg shadow-lg py-2">
                    <a href="/" class="block px-4 py-2 hover:bg-gray-700">Home</a>
                    <a href="/about" class="block px-4 py-2 hover:bg-gray-700">About</a>
                    <a href="/contact" class="block px-4 py-2 hover:bg-gray-700">Contact</a>
                </div>
            </div>
        </div>
    </div>
</nav>


    <div class="bg-gray-50 h-screen w-full">

    <!-- Reusable Alpine component factory -->
    <script>
        function categoryCard(props) {
            return {
                // 🧩 Default props + incoming overrides
                title: "Computer Science / IT",
                slug: "computer-science-it",
                description: "Learn programming, web development, data science, and cybersecurity—from fundamentals to advanced topics.",
                courses: 48,
                lessons: 620,
                rating: 4.7,
                students: 12500,
                tags: ["Programming", "Web Dev", "Data Science", "Cybersecurity"],
                image: "https://images.unsplash.com/photo-1518779578993-ec3579fee39f?q=80&w=1600&auto=format&fit=crop",
                accent: "blue",
                href: "#",
                ...props,

                // 🧠 Derived/computed
                get accentClasses() {
                    const map = {
                        blue:   "bg-blue-50 text-blue-700 ring-blue-200",
                        violet: "bg-violet-50 text-violet-700 ring-violet-200",
                        emerald:"bg-emerald-50 text-emerald-700 ring-emerald-200",
                        rose:   "bg-rose-50 text-rose-700 ring-rose-200",
                        amber:  "bg-amber-50 text-amber-700 ring-amber-200",
                        slate:  "bg-slate-50 text-slate-700 ring-slate-200",
                    };
                    return map[this.accent] || map.blue;
                },
                get btnClasses() {
                    const map = {
                        blue:   "bg-blue-600 hover:bg-blue-700 focus-visible:ring-blue-300",
                        violet: "bg-violet-600 hover:bg-violet-700 focus-visible:ring-violet-300",
                        emerald:"bg-emerald-600 hover:bg-emerald-700 focus-visible:ring-emerald-300",
                        rose:   "bg-rose-600 hover:bg-rose-700 focus-visible:ring-rose-300",
                        amber:  "bg-amber-600 hover:bg-amber-700 focus-visible:ring-amber-300",
                        slate:  "bg-slate-800 hover:bg-slate-900 focus-visible:ring-slate-300",
                    };
                    return map[this.accent] || map.blue;
                },

                // 🔔 Actions
                go() { window.location.href = this.href; },
            }
        }
    </script>

    <!-- Demo grid (mobile → desktop) -->
    <div class="max-w-screen mx-auto p-4 sm:p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Featured Category</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- ✅ Computer Science / IT Card (Dynamic) -->
            <article
                x-data="categoryCard({
          title: 'Computer Science / IT',
          slug: 'computer-science-it',
          description: 'Master coding, full-stack web, data science, and security with hands-on projects.',
          courses: 52,
          lessons: 740,
          rating: 4.8,
          students: 15890,
          tags: ['Programming', 'Web Dev', 'Data Science', 'Cybersecurity'],
          accent: 'blue',
          href: '/categories/computer-science-it'
        })"
                class="group relative bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 hover:shadow-xl transition-shadow overflow-hidden"
            >
                <!-- Cover image -->
                <div class="aspect-[16/9] w-full overflow-hidden bg-gray-100">
                    <img :src="image"
                         alt=""
                         class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                </div>

                <!-- Content -->
                <div class="p-5">
                    <!-- Badge + rating -->
                    <div class="flex items-center justify-between mb-3">
            <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full ring-1"
                  :class="accentClasses">
              <!-- Heroicon: Cpu Chip -->
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                      d="M9.75 9.75h4.5v4.5h-4.5z"/>
                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                      d="M8.25 3.75v2.5m3.25-2.5v2.5m3.25-2.5v2.5M8.25 17.75v2.5m3.25-2.5v2.5m3.25-2.5v2.5M3.75 8.25h2.5m-2.5 3.25h2.5m-2.5 3.25h2.5M17.75 8.25h2.5m-2.5 3.25h2.5m-2.5 3.25h2.5"/>
                <rect x="5.25" y="5.25" width="13.5" height="13.5" rx="2.25" stroke="currentColor" stroke-width="1.5"/>
              </svg>
              <span x-text="title"></span>
            </span>

                        <div class="flex items-center gap-1 text-sm text-amber-500">
                            <!-- Heroicon: Star Solid -->
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.036a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.036a1 1 0 00-1.176 0l-2.802 2.036c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.88 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span x-text="rating.toFixed(1)"></span>
                        </div>
                    </div>

                    <!-- Title -->
                    <h3 class="text-lg font-semibold text-gray-900 leading-tight">
                        <a :href="href" class="focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 rounded-lg"
                           :class="btnClasses.replace('bg-','ring-').replace('hover:','')">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <span x-text="title"></span>
                        </a>
                    </h3>

                    <!-- Description -->
                    <p class="mt-2 text-sm text-gray-600 line-clamp-3" x-text="description"></p>

                    <!-- Stats -->
                    <div class="mt-4 grid grid-cols-3 gap-3 text-sm text-gray-700">
                        <div class="flex items-center gap-2">
                            <!-- Heroicon: Book Open -->
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 6.75c-1.5-1.2-3.75-2-6-2v12c2.25 0 4.5.75 6 2m0-12c1.5-1.2 3.75-2 6-2v12c-2.25 0-4.5.75-6 2m0-12v12"/>
                            </svg>
                            <span><span class="font-semibold" x-text="courses"></span> Courses</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Heroicon: Queue List -->
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                      d="M8.25 6.75h12M8.25 12h12M8.25 17.25h12M3.75 6.75h.01M3.75 12h.01M3.75 17.25h.01"/>
                            </svg>
                            <span><span class="font-semibold" x-text="lessons"></span> Lessons</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Heroicon: Users -->
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 19.5a4.5 4.5 0 10-6 0M18 8.25a3 3 0 11-6 0 3 3 0 016 0zM6 8.25a3 3 0 106 0 3 3 0 00-6 0z"/>
                            </svg>
                            <span><span class="font-semibold" x-text="students.toLocaleString()"></span> Students</span>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        <template x-for="tag in tags" :key="tag">
              <span class="px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 ring-1 ring-gray-200"
                    x-text="tag"></span>
                        </template>
                    </div>

                    <!-- CTA -->
                    <div class="mt-5 flex items-center justify-between">
                        <button
                            @click="go()"
                            class="inline-flex items-center gap-2 text-sm font-medium text-white px-4 py-2 rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2"
                            :class="btnClasses"
                        >
                            <!-- Heroicon: Arrow Right -->
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                      d="M13.5 4.5l6 7.5-6 7.5M3 12h16.5"/>
                            </svg>
                            Explore
                        </button>

                        <!-- Quick slug copy (example dynamic action) -->
                        <button
                            @click="navigator.clipboard.writeText(slug)"
                            class="text-xs text-gray-500 hover:text-gray-700 underline"
                            title="Copy slug"
                        >
                            Copy slug
                        </button>
                    </div>
                </div>
            </article>

            <!-- ♻️ Example: another instance with different accent (optional) -->
            <article
                x-data="categoryCard({
          title: 'Computer Science / IT',
          description: 'Algorithms, data structures, and systems—CS core made friendly.',
          courses: 36, lessons: 410, rating: 4.6, students: 9800,
          accent: 'emerald', href: '/categories/cs-core'
        })"
                class="group relative bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 hover:shadow-xl transition-shadow overflow-hidden"
            >
                <div class="aspect-[16/9] w-full overflow-hidden bg-gray-100">
                    <img :src="image" alt="" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between mb-3">
            <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full ring-1" :class="accentClasses">
              <!-- Heroicon: Cpu Chip -->
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75h4.5v4.5h-4.5z"/>
                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M8.25 3.75v2.5m3.25-2.5v2.5m3.25-2.5v2.5M8.25 17.75v2.5m3.25-2.5v2.5m3.25-2.5v2.5M3.75 8.25h2.5m-2.5 3.25h2.5m-2.5 3.25h2.5M17.75 8.25h2.5m-2.5 3.25h2.5m-2.5 3.25h2.5"/>
                <rect x="5.25" y="5.25" width="13.5" height="13.5" rx="2.25" stroke="currentColor" stroke-width="1.5"/>
              </svg>
              <span x-text="title"></span>
            </span>
                        <div class="flex items-center gap-1 text-sm text-amber-500">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.036a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.036a1 1 0 00-1.176 0l-2.802 2.036c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.88 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span x-text="rating.toFixed(1)"></span>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 leading-tight" x-text="title"></h3>
                    <p class="mt-2 text-sm text-gray-600 line-clamp-3" x-text="description"></p>
                    <div class="mt-4 grid grid-cols-3 gap-3 text-sm text-gray-700">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 6.75c-1.5-1.2-3.75-2-6-2v12c2.25 0 4.5.75 6 2m0-12c1.5-1.2 3.75-2 6-2v12c-2.25 0-4.5.75-6 2m0-12v12"/></svg>
                            <span><span class="font-semibold" x-text="courses"></span> Courses</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12M8.25 17.25h12M3.75 6.75h.01M3.75 12h.01M3.75 17.25h.01"/></svg>
                            <span><span class="font-semibold" x-text="lessons"></span> Lessons</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M15 19.5a4.5 4.5 0 10-6 0M18 8.25a3 3 0 11-6 0 3 3 0 016 0zM6 8.25a3 3 0 106 0 3 3 0 00-6 0z"/></svg>
                            <span><span class="font-semibold" x-text="students.toLocaleString()"></span> Students</span>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <template x-for="tag in tags" :key="tag">
                            <span class="px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-700 ring-1 ring-gray-200" x-text="tag"></span>
                        </template>
                    </div>
                    <div class="mt-5">
                        <button @click="go()"
                                class="inline-flex items-center gap-2 text-sm font-medium text-white px-4 py-2 rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2"
                                :class="btnClasses">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5l6 7.5-6 7.5M3 12h16.5"/></svg>
                            Explore
                        </button>
                    </div>
                </div>
            </article>

        </div>
    </div>

    <!-- Optional: line-clamp for multi-line truncation -->
    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    </div>




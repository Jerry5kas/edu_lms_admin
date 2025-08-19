<div class="flex items-center justify-between px-4 py-3">
    <!-- Left -->
    <button class="lg:hidden p-2 rounded-md bg-gray-100" @click="sidebarOpen = true">
        ☰
    </button>

    <div class="flex-1 flex justify-center">
        <input type="text" placeholder="Search..." class="w-1/2 px-4 py-2 rounded-lg border focus:outline-blue-400"/>
    </div>

    <!-- Right -->
    <div class="flex items-center gap-4">
        <button class="p-2 rounded-full bg-gray-100">🔔</button>
        <img src="https://i.pravatar.cc/40" alt="user" class="w-10 h-10 rounded-full"/>
    </div>
</div>


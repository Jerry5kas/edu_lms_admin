
    <x-layouts.main>
        <div class="bg-gray-50 min-h-screen p-4 flex justify-center items-center">
            <div class="bg-white shadow-lg rounded-2xl w-full max-w-3xl p-6 space-y-6">

                <!-- Header -->
                <div class="flex items-center gap-2">
                    <!-- Heroicon: pencil -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    <h1 class="text-xl font-semibold text-gray-800">Edit Notification</h1>
                </div>

                <!-- Form -->
                <form method="POST" action="#" class="space-y-5"
                      x-data="{
                        title: '{{ $notification->subject }}',
                        message: '{{ $notification->body }}',
                        type: '{{ $notification->type }}',
                        channel: '{{ $notification->channel }}',
                        scheduled: '{{ $notification->scheduled_for }}'
                  }">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div>
                        <label class="block text-gray-600 text-sm font-medium mb-1">Title</label>
                        <div class="flex items-center border rounded-lg px-2">
                            <!-- Heroicon: pencil-alt -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            <input type="text" name="title" x-model="title"
                                   class="w-full px-2 py-2 text-sm focus:ring-0 focus:outline-none"
                                   placeholder="Enter notification title">
                        </div>
                    </div>

                    <!-- Message -->
                    <div>
                        <label class="block text-gray-600 text-sm font-medium mb-1">Message</label>
                        <textarea name="message" x-model="message" rows="4"
                                  class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 focus:outline-none"
                                  placeholder="Enter your message"></textarea>
                    </div>

                    <!-- Type & Channel -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-600 text-sm font-medium mb-1">Type</label>
                            <select name="type" x-model="type"
                                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400">
                                <option value="system">System</option>
                                <option value="marketing">Marketing</option>
                                <option value="enrollment">Enrollment</option>
                                <option value="payment">Payment</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-600 text-sm font-medium mb-1">Channel</label>
                            <select name="channel" x-model="channel"
                                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-400">
                                <option value="email">Email</option>
                                <option value="sms">SMS</option>
                                <option value="in_app">In-App</option>
                            </select>
                        </div>
                    </div>

                    <!-- Schedule -->
                    <div>
                        <label class="block text-gray-600 text-sm font-medium mb-1">Schedule For</label>
                        <div class="flex items-center border rounded-lg px-2">
                            <!-- Heroicon: calendar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-11 8h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <input type="datetime-local" name="scheduled_for" x-model="scheduled"
                                   class="w-full px-2 py-2 text-sm focus:ring-0 focus:outline-none">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-end">
                        <a href="/notifications"
                           class="flex items-center justify-center gap-2 border px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
                            <!-- Heroicon: arrow-left -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back to List
                        </a>
                        <button type="submit"
                                class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow">
                            <!-- Heroicon: check -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Notification
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-layouts.main>



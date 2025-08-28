<x-layouts.main>
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Webhook Event Details</h1>
                <p class="text-gray-600 mt-1">Event ID: {{ $webhook->id }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('webhooks.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Webhooks
                </a>
            </div>
        </div>

        <!-- Webhook Status Badge -->
        <div class="mb-6">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                {{ $webhook->processing_status === 'processed' ? 'bg-green-100 text-green-800' : 
                   ($webhook->processing_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                   ($webhook->processing_status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                {{ ucfirst($webhook->processing_status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Webhook Summary -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Webhook Event Summary</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Event ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $webhook->id }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Event Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $webhook->event_type }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Source</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($webhook->source) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Received At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $webhook->created_at->format('M d, Y H:i:s') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Processing Status</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $webhook->processing_status === 'processed' ? 'bg-green-100 text-green-800' : 
                                           ($webhook->processing_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($webhook->processing_status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst($webhook->processing_status) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Retry Count</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $webhook->retry_count ?? 0 }}</dd>
                            </div>
                            @if($webhook->processed_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Processed At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $webhook->processed_at->format('M d, Y H:i:s') }}</dd>
                            </div>
                            @endif
                            @if($webhook->next_retry_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Next Retry At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $webhook->next_retry_at->format('M d, Y H:i:s') }}</dd>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Webhook Payload -->
                <div class="bg-white shadow rounded-lg mt-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Webhook Payload</h3>
                    </div>
                    <div class="p-6">
                        @if($webhook->payload)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <pre class="text-sm text-gray-800 overflow-x-auto">{{ json_encode(json_decode($webhook->payload), JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">No payload data available</p>
                        @endif
                    </div>
                </div>

                <!-- Processing Result -->
                @if($webhook->processing_result)
                <div class="bg-white shadow rounded-lg mt-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Processing Result</h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <pre class="text-sm text-gray-800 overflow-x-auto">{{ json_encode(json_decode($webhook->processing_result), JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Error Details -->
                @if($webhook->error_message)
                <div class="bg-white shadow rounded-lg mt-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Error Details</h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <p class="text-sm text-red-800">{{ $webhook->error_message }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Related Data -->
                @if($webhook->related_order_id || $webhook->related_payment_id)
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Related Data</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @if($webhook->related_order_id)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Related Order</dt>
                            <dd class="mt-1">
                                <a href="{{ route('orders.show', $webhook->related_order_id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    View Order #{{ $webhook->related_order_id }}
                                </a>
                            </dd>
                        </div>
                        @endif
                        
                        @if($webhook->related_payment_id)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Related Payment</dt>
                            <dd class="mt-1">
                                <a href="{{ route('payments.show', $webhook->related_payment_id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    View Payment #{{ $webhook->related_payment_id }}
                                </a>
                            </dd>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Actions</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        @if($webhook->processing_status === 'pending')
                        <form action="{{ route('webhooks.process', $webhook) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Process Now
                            </button>
                        </form>
                        @endif

                        @if($webhook->processing_status === 'failed')
                        <form action="{{ route('webhooks.retry', $webhook) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Retry Processing
                            </button>
                        </form>
                        @endif

                        <form action="{{ route('webhooks.destroy', $webhook) }}" method="POST" class="inline" 
                              onsubmit="return confirm('Are you sure you want to delete this webhook event?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Event
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Event Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Event Information</h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Event Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $webhook->event_type }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Source</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($webhook->source) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">IP Address</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $webhook->ip_address ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">User Agent</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ Str::limit($webhook->user_agent ?? 'N/A', 50) }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>


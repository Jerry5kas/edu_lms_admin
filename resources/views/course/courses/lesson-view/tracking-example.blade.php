<x-layouts.main>
    <div class="bg-white p-6">
        <div class="w-full max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Lesson Tracking Integration Example</h1>
            
            <div class="bg-blue-50 rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">How to Integrate Lesson Tracking</h2>
                <p class="text-gray-600">This example shows how to use the lesson tracking endpoints in your frontend application.</p>
            </div>

            <!-- API Endpoints -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Available API Endpoints</h3>
                <div class="space-y-3">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <code class="text-sm text-blue-600">POST /lessons/{lesson}/start</code>
                        <p class="text-sm text-gray-600 mt-1">Start a lesson - creates lesson view entry</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <code class="text-sm text-blue-600">POST /lessons/{lesson}/track-progress</code>
                        <p class="text-sm text-gray-600 mt-1">Update progress while watching</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <code class="text-sm text-blue-600">POST /lessons/{lesson}/complete</code>
                        <p class="text-sm text-gray-600 mt-1">Mark lesson as completed</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <code class="text-sm text-blue-600">GET /lessons/{lesson}/progress</code>
                        <p class="text-sm text-gray-600 mt-1">Get current user's progress</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <code class="text-sm text-blue-600">GET /courses/{course}/progress</code>
                        <p class="text-sm text-gray-600 mt-1">Get course progress for current user</p>
                    </div>
                </div>
            </div>

            <!-- JavaScript Example -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">JavaScript Integration Example</h3>
                <div class="bg-gray-900 rounded-lg p-4">
                    <pre class="text-green-400 text-sm overflow-x-auto"><code>// Lesson tracking class
class LessonTracker {
    constructor(lessonId) {
        this.lessonId = lessonId;
        this.isTracking = false;
        this.startTime = null;
        this.lastPosition = 0;
        this.interval = null;
    }

    // Start tracking when user begins lesson
    async startLesson() {
        try {
            const response = await fetch(`/lessons/${this.lessonId}/start`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            if (data.success) {
                this.isTracking = true;
                this.startTime = Date.now();
                console.log('Lesson started:', data.message);
            }
        } catch (error) {
            console.error('Error starting lesson:', error);
        }
    }

    // Track progress while watching
    async trackProgress(secondsWatched, lastPositionSeconds, isCompleted = false) {
        try {
            const response = await fetch(`/lessons/${this.lessonId}/track-progress`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    seconds_watched: secondsWatched,
                    last_position_seconds: lastPositionSeconds,
                    is_completed: isCompleted
                })
            });
            
            const data = await response.json();
            if (data.success) {
                this.lastPosition = lastPositionSeconds;
                console.log('Progress tracked:', data.progress + '%');
                
                // Update UI with progress
                this.updateProgressUI(data.progress);
            }
        } catch (error) {
            console.error('Error tracking progress:', error);
        }
    }

    // Complete the lesson
    async completeLesson() {
        try {
            const response = await fetch(`/lessons/${this.lessonId}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            if (data.success) {
                this.isTracking = false;
                console.log('Lesson completed!');
                this.showCompletionMessage();
            }
        } catch (error) {
            console.error('Error completing lesson:', error);
        }
    }

    // Get current progress
    async getProgress() {
        try {
            const response = await fetch(`/lessons/${this.lessonId}/progress`);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error getting progress:', error);
            return null;
        }
    }

    // Start automatic tracking (for video players)
    startAutoTracking(videoElement) {
        if (!this.isTracking) {
            this.startLesson();
        }

        this.interval = setInterval(() => {
            if (videoElement && !videoElement.paused) {
                const currentTime = Math.floor(videoElement.currentTime);
                const duration = Math.floor(videoElement.duration);
                const isCompleted = currentTime >= duration * 0.9; // 90% watched

                this.trackProgress(currentTime, currentTime, isCompleted);

                if (isCompleted && this.isTracking) {
                    this.completeLesson();
                    clearInterval(this.interval);
                }
            }
        }, 5000); // Track every 5 seconds
    }

    // Stop tracking
    stopTracking() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
        this.isTracking = false;
    }

    // Update progress UI
    updateProgressUI(progress) {
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        
        if (progressBar) {
            progressBar.style.width = progress + '%';
        }
        if (progressText) {
            progressText.textContent = Math.round(progress) + '%';
        }
    }

    // Show completion message
    showCompletionMessage() {
        const message = document.createElement('div');
        message.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
        message.textContent = '🎉 Lesson completed!';
        document.body.appendChild(message);
        
        setTimeout(() => {
            message.remove();
        }, 3000);
    }
}

// Usage example
document.addEventListener('DOMContentLoaded', function() {
    const lessonId = 1; // Replace with actual lesson ID
    const tracker = new LessonTracker(lessonId);
    
    // For video elements
    const video = document.querySelector('video');
    if (video) {
        video.addEventListener('play', () => {
            tracker.startAutoTracking(video);
        });
        
        video.addEventListener('pause', () => {
            tracker.stopTracking();
        });
    }
    
    // Manual tracking for other content types
    const contentElement = document.querySelector('.lesson-content');
    if (contentElement) {
        let scrollProgress = 0;
        
        contentElement.addEventListener('scroll', () => {
            const scrollTop = contentElement.scrollTop;
            const scrollHeight = contentElement.scrollHeight - contentElement.clientHeight;
            scrollProgress = Math.floor((scrollTop / scrollHeight) * 100);
            
            tracker.trackProgress(scrollProgress, scrollProgress, scrollProgress >= 90);
        });
    }
});</code></pre>
                </div>
            </div>

            <!-- Workflow Summary -->
            <div class="bg-green-50 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Workflow Summary</h3>
                <ol class="list-decimal list-inside space-y-2 text-gray-700">
                    <li><strong>Start Lesson:</strong> Call <code>/lessons/{id}/start</code> when user begins</li>
                    <li><strong>Track Progress:</strong> Call <code>/lessons/{id}/track-progress</code> periodically</li>
                    <li><strong>Complete Lesson:</strong> Call <code>/lessons/{id}/complete</code> when finished</li>
                    <li><strong>Get Progress:</strong> Call <code>/lessons/{id}/progress</code> to retrieve current status</li>
                </ol>
            </div>

            <!-- Back Button -->
            <div class="mt-8">
                <a href="{{ route('lesson-views.index') }}" 
                   class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    ← Back to Lesson Views
                </a>
            </div>
        </div>
    </div>
</x-layouts.main>

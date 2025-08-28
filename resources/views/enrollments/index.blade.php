
<x-layouts.main>
@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-bold mb-4">My Courses</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($enrollments->isEmpty())
            <p>You are not enrolled in any courses yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($enrollments as $enrollment)
                    <div class="bg-white shadow rounded-lg p-4">
                        <h3 class="font-bold text-lg">{{ $enrollment->course->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $enrollment->course->subtitle }}</p>
                        <a href="{{ route('courses.show', $enrollment->course->id) }}" class="mt-2 inline-block text-orange-500 hover:underline">
                            Go to Course →
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.main>

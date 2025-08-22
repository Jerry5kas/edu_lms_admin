<x-layouts.main>
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Create Category</h2>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="block">Slug</label>
                <input type="text" name="slug" class="border rounded w-full p-2">
            </div>

            <div class="mb-3">
                <label class="block">Name</label>
                <input type="text" name="name" class="border rounded w-full p-2">
            </div>

            <div class="mb-3">
                <label class="block">Parent</label>
                <select name="parent_id" class="border rounded w-full p-2">
                    <option value="">None</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</x-layouts.main>

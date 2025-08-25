<x-layouts.main>
    <div class="bg-white p-6">
        <div class="w-full max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Upload Media</h1>
                <p class="text-gray-600">Upload files to your media library</p>
            </div>
            
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('media.index') }}" 
                   class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    ← Back to Media Library
                </a>
            </div>

            <!-- Upload Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- File Upload -->
                    <div class="mb-6">
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                            Select File <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload a file</span>
                                        <input id="file" name="file" type="file" class="sr-only" required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF, PDF, DOC, MP4 up to 10MB
                                </p>
                            </div>
                        </div>
                        
                        @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Storage Options -->
                    <div class="mb-6">
                        <label for="disk" class="block text-sm font-medium text-gray-700 mb-2">
                            Storage Location
                        </label>
                        <select name="disk" id="disk" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="public">Local Storage (Public)</option>
                            <option value="s3">Amazon S3</option>
                            <option value="bunny">Bunny CDN</option>
                        </select>
                        <p class="mt-1 text-sm text-gray-500">
                            Choose where to store your file. Local storage is recommended for small files.
                        </p>
                    </div>

                    <!-- File Preview -->
                    <div id="file-preview" class="mb-6 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">File Preview</label>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div id="preview-content" class="text-center">
                                <!-- Preview content will be inserted here -->
                            </div>
                            <div id="file-info" class="mt-3 text-sm text-gray-600">
                                <!-- File info will be inserted here -->
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('media.index') }}"
                           class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Upload File
                        </button>
                    </div>
                </form>
            </div>

            <!-- Upload Guidelines -->
            <div class="bg-blue-50 rounded-lg p-6 mt-6">
                <h3 class="text-lg font-medium text-blue-900 mb-3">Upload Guidelines</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
                    <div>
                        <h4 class="font-medium mb-2">Supported File Types:</h4>
                        <ul class="space-y-1">
                            <li>• Images: JPG, PNG, GIF, WebP</li>
                            <li>• Videos: MP4, AVI, MOV, WebM</li>
                            <li>• Documents: PDF, DOC, DOCX, TXT</li>
                            <li>• Other: ZIP, RAR (max 10MB)</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-medium mb-2">Best Practices:</h4>
                        <ul class="space-y-1">
                            <li>• Use descriptive filenames</li>
                            <li>• Optimize images before upload</li>
                            <li>• Keep file sizes reasonable</li>
                            <li>• Use appropriate storage location</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // File preview functionality
        document.getElementById('file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('file-preview');
            const previewContent = document.getElementById('preview-content');
            const fileInfo = document.getElementById('file-info');
            
            if (file) {
                preview.classList.remove('hidden');
                
                // File info
                const size = (file.size / 1024 / 1024).toFixed(2);
                fileInfo.innerHTML = `
                    <div class="grid grid-cols-2 gap-4">
                        <div><strong>Name:</strong> ${file.name}</div>
                        <div><strong>Size:</strong> ${size} MB</div>
                        <div><strong>Type:</strong> ${file.type}</div>
                        <div><strong>Last Modified:</strong> ${new Date(file.lastModified).toLocaleDateString()}</div>
                    </div>
                `;
                
                // Preview content
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContent.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" class="max-w-full max-h-64 mx-auto rounded">
                        `;
                    };
                    reader.readAsDataURL(file);
                } else if (file.type.startsWith('video/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContent.innerHTML = `
                            <video controls class="max-w-full max-h-64 mx-auto rounded">
                                <source src="${e.target.result}" type="${file.type}">
                                Your browser does not support the video tag.
                            </video>
                        `;
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewContent.innerHTML = `
                        <div class="text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-600">${file.name}</p>
                        </div>
                    `;
                }
            } else {
                preview.classList.add('hidden');
            }
        });
    </script>
</x-layouts.main>

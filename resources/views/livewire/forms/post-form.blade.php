<div class="p-4">
    <form wire:submit.prevent="savePost">
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
            <input type="text" id="title" wire:model.live="title"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            @error('title')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
            <input type="text" id="slug" wire:model="slug"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            @error('slug')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content</label>
            <textarea id="content" wire:model="content" rows="10"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"></textarea>
            @error('content')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Excerpt</label>
            <textarea id="excerpt" wire:model="excerpt" rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"></textarea>
            @error('excerpt')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Featured Image</label>

            @if ($currentImage && !$image)
                <div class="mt-3">
                    <div class="relative group w-60 aspect-square bg-gray-800 border border-gray-700 rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all">
                        <img src="{{ Storage::url($currentImage) }}" alt="Featured" class="object-cover w-full h-full transition-transform duration-200 group-hover:scale-105" />
                        <button type="button" wire:click="$set('currentImage', null)" class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700 transition">
                            ✕
                        </button>
                    </div>
                    <div class="mt-2">
                        <button type="button" wire:click="openMediaLibrary" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Change Image from Media Library
                        </button>
                    </div>
                </div>
            @else
                <input type="file" id="image" wire:model="image"
                    class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
            file:mr-4 file:py-2 file:px-4
            file:rounded-md file:border-0
            file:text-sm file:font-semibold
            file:bg-indigo-50 file:text-indigo-700
            hover:file:bg-indigo-100">
                <div wire:loading wire:target="image" class="text-indigo-500 text-sm mt-1">Uploading image...</div>

                <div class="mt-2">
                    <button type="button" wire:click="openMediaLibrary" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Select from Media Library
                    </button>
                </div>
            @endif

            @error('image')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="categories" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categories</label>
            <select multiple wire:model="selectedCategories" id="categories"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                @foreach ($allCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('selectedCategories')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
            <select id="status" wire:model="status"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>
            @error('status')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Published At</label>
            <input type="datetime-local" id="published_at" wire:model="published_at"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            @error('published_at')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end gap-x-2">
            <button type="button" wire:click="$dispatch('closePostFormModal')"
                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                Cancel
            </button>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Save Post
            </button>
        </div>
    </form>
    @if ($selectingFromMedia)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg max-w-4xl w-full overflow-auto max-h-[80vh]">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Select Image from Media</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach ($mediaFiles as $file)
                        <div class="relative cursor-pointer" wire:click="selectMedia('{{ $file }}')">
                            <img src="{{ Storage::url($file) }}" class="w-full h-32 object-cover rounded-md border hover:border-indigo-500 transition">
                            <p class="text-xs mt-1 text-gray-500 dark:text-gray-400 truncate">{{ basename($file) }}</p>
                        </div>
                    @endforeach
                </div>
                <button wire:click="$set('selectingFromMedia', false)" class="mt-6 text-sm text-gray-500 dark:text-gray-300 underline">Cancel</button>
            </div>
        </div>
    @endif
</div>

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
            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Featured Image</label>
            @if ($currentImage && !$image)
                <div class="mt-2">
                    <img src="{{ Storage::url($currentImage) }}" alt="Current Image" class="max-w-xs h-auto rounded-md">
                    <button type="button" wire:click="$set('currentImage', null)" class="text-red-500 text-sm mt-1">Remove Image</button>
                </div>
            @endif
            <input type="file" id="image" wire:model="image"
                class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                file:mr-4 file:py-2 file:px-4
                file:rounded-md file:border-0
                file:text-sm file:font-semibold
                file:bg-indigo-50 file:text-indigo-700
                hover:file:bg-indigo-100">
            @error('image')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
            <div wire:loading wire:target="image" class="text-indigo-500 text-sm mt-1">Uploading image...</div>
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
</div>

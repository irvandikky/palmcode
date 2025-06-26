<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-medium text-gray-900 dark:text-gray-100 mb-6">
                    Media Manager
                </h2>

                <div x-data x-on:dragover.prevent x-on:drop.prevent="$refs.fileInput.files = $event.dataTransfer.files; $refs.fileInput.dispatchEvent(new Event('change'))"
                    class="w-full flex items-center justify-center border-2 border-dashed rounded-md text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-gray-700 transition cursor-pointer"
                    x-on:click="$refs.fileInput.click()" style="height: 300px">
                    <span>Drag and drop image here, or click to select</span>
                    <input type="file" wire:model="file" x-ref="fileInput" class="hidden" />
                </div>

                @error('file')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror

                @if ($file)
                    <div wire:loading wire:target="file" class="mt-4 w-full">
                        <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-gray-700">
                            <div x-data="{ progress: 0 }" x-init="Livewire.on('upload-start', () => progress = 0);
                            Livewire.on('upload-progress', p => progress = p);
                            Livewire.on('upload-finish', () => progress = 100);
                            Livewire.on('upload-error', () => progress = 0);" x-bind:style="'width: ' + progress + '%'" class="bg-indigo-600 h-3 rounded-full transition-all"></div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 mt-6">
                    @forelse ($files as $file)
                        <div class="relative bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded shadow overflow-hidden">
                            <img src="{{ asset('storage/' . $file) }}" class="w-full h-48 object-cover" alt="Media file">

                            <div class="absolute top-1 right-1">
                                <button wire:click="delete('{{ $file }}')" class="bg-red-600 text-white rounded-full px-2.5 py-1 hover:bg-red-700 transition">
                                    ✕
                                </button>
                            </div>

                            <div class="px-2 py-1 text-xs text-gray-600 dark:text-gray-300 truncate">
                                {{ basename($file) }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 md:col-span-4 text-center text-gray-500 dark:text-gray-400">
                            No media files found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-medium text-gray-900 dark:text-gray-100 mb-6">
                    Manage Posts
                </h2>

                <div class="flex items-center justify-between mb-4">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search posts..." class="form-input rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200 w-1/3">
                    <button wire:click="createPost"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Add New Post
                    </button>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Image
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Exerpt
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Published At
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($posts as $post)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $post->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        <img src="{{ $post->image ? \Storage::url($post->image) : 'https://placehold.co/150x150?text=No+Image' }}" class="max-w-20 rounded-lg" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $post->excerpt }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $post->published_at?->format('d M Y H:i:s') ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button wire:click="editPost({{ $post->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 mr-3">Edit</button>
                                        <button wire:click="deletePost({{ $post->id }})" wire:confirm="Are you sure you want to delete this post?"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                        No posts found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Post Form Modal -->
    @if ($showPostFormModal)
        <div class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" style="display: block;">
            <div class="fixed inset-0 transform transition-all" wire:click="$set('showPostFormModal', false)">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform sm:w-full sm:mx-auto max-w-2xl" x-data="{ show: @entangle('showPostFormModal') }" x-init="$watch('show', value => {
                if (value) { document.body.classList.add('overflow-y-hidden'); } else { document.body.classList.remove('overflow-y-hidden'); }
            })" x-show="show" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="px-6 py-4">
                    <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ $editingPostId ? 'Edit Post' : 'Create New Post' }}
                    </div>
                    <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                        <livewire:forms.post-form :post-id="$editingPostId" @post-saved="$refresh" />
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

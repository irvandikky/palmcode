@php
    use App\Models\Post;
    use App\Models\Category;

    $postCount = Post::count();
    $pageCount = Post::count();
    $categoryCount = Category::count();
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid md:grid-cols-3 gap-4 md:gap-6">
                        <div class="bg-blue-100 dark:bg-blue-800 p-4 rounded-xl shadow">
                            <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100">Posts</h3>
                            <p class="text-3xl">{{ $postCount }}</p>
                        </div>

                        <div class="bg-green-100 dark:bg-green-800 p-4 rounded-xl shadow">
                            <h3 class="text-lg font-bold text-green-900 dark:text-green-100">Pages</h3>
                            <p class="text-3xl">{{ $pageCount }}</p>
                        </div>

                        <div class="bg-yellow-100 dark:bg-yellow-800 p-4 rounded-xl shadow">
                            <h3 class="text-lg font-bold text-yellow-900 dark:text-yellow-100">Categories</h3>
                            <p class="text-3xl">{{ $categoryCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

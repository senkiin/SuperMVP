{{-- Gestión de Categorías Moderna --}}
<div class="p-6 lg:p-8 max-w-7xl mx-auto">
    {{-- Header Section --}}
    <div class="mt-12 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/25">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Category Management</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Organize your documents with custom categories</p>
                </div>
            </div>
            <button wire:click="addCategory"
                    class="group relative px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-medium hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 inline-block mr-2 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Category
            </button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Categories</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $categories->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Categories</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $categories->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Documents Tagged</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $categories->sum('documents_count') ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Modern Categories Grid --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Categories</h2>
        </div>

        @if($categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-6">
                @foreach($categories as $cat)
                    <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg hover:shadow-gray-500/10 dark:hover:shadow-gray-900/20 transition-all duration-200 hover:-translate-y-1">
                        {{-- Color indicator --}}
                        <div class="absolute top-4 right-4 w-8 h-8 rounded-full shadow-lg" style="background-color: {{ $cat->color }};"></div>

                        {{-- Category Icon --}}
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4 shadow-lg" style="background-color: {{ $cat->color }}20; border: 2px solid {{ $cat->color }}40;">
                            <svg class="w-6 h-6" style="color: {{ $cat->color }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>

                        {{-- Category Info --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $cat->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                {{ $cat->description ?: 'No description provided' }}
                            </p>
                        </div>

                        {{-- Color code --}}
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                {{ $cat->color }}
                            </span>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center space-x-2">
                            <button wire:click="manageCategory({{ $cat->id }})"
                                    class="flex-1 px-4 py-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl font-medium hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-all duration-200 hover:scale-105 active:scale-95">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </button>
                            <button wire:click="confirmCategoryDeletion({{ $cat->id }})"
                                    class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-xl transition-all duration-200 hover:scale-105 active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-16 px-6">
                <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-indigo-400 dark:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No categories yet</h3>
                <p class="text-gray-600 dark:text-gray-400 text-center mb-6">Get started by creating your first category to organize your documents</p>
                <button wire:click="addCategory"
                        class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-medium hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                    Create First Category
                </button>
            </div>
        @endif
    </div>

    {{-- Modern Add/Edit Modal --}}
    @if($managingCategory)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-opacity"
                 x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block w-full max-w-md p-6 my-8 text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl border border-gray-200/50 dark:border-gray-700/50"
                 x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <form wire:submit.prevent="saveCategory" class="space-y-6">
                    {{-- Modal Header --}}
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $category->exists ? 'Edit Category' : 'Create New Category' }}
                            </h3>
                        </div>
                        <button wire:click="$set('managingCategory', false)"
                                class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Form Fields --}}
                    <div class="space-y-4">
                        {{-- Name Field --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category Name</label>
                            <input wire:model.defer="name"
                                   type="text"
                                   class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all duration-200"
                                   placeholder="Enter category name">
                            @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Description Field --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                            <textarea wire:model.defer="description"
                                      rows="3"
                                      class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all duration-200 resize-none"
                                      placeholder="Describe this category..."></textarea>
                            @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Color Field --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Color</label>
                            <div class="flex items-center space-x-3">
                                <input wire:model.defer="color"
                                       type="color"
                                       class="w-16 h-12 border-2 border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer">
                                <input wire:model.defer="color"
                                       type="text"
                                       class="flex-1 px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all duration-200"
                                       placeholder="#3B82F6">
                            </div>
                            @error('color') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center space-x-3 pt-4">
                        <button type="submit"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-medium hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                            {{ $category->exists ? 'Update Category' : 'Create Category' }}
                        </button>
                        <button wire:click="$set('managingCategory', false)"
                                type="button"
                                class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 hover:scale-105 active:scale-95">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Modern Delete Confirmation Modal --}}
    @if($confirmingCategoryDeletion)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-transition>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-opacity"
                 x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block w-full max-w-md p-6 my-8 text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl border border-gray-200/50 dark:border-gray-700/50"
                 x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                {{-- Warning Icon --}}
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-red-100 dark:bg-red-900/30 rounded-full">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.238 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>

                {{-- Content --}}
                <div class="text-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Category</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Are you sure you want to delete the category <strong>"{{ $category->name }}"</strong>? This action cannot be undone.
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex items-center space-x-3">
                    <button wire:click="deleteCategory"
                            class="flex-1 px-6 py-3 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                        Delete Category
                    </button>
                    <button wire:click="$set('confirmingCategoryDeletion', false)"
                            class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 hover:scale-105 active:scale-95">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- Estilos adicionales --}}
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

</div>


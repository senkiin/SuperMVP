{{-- Gestor de Campos de Formulario Moderno --}}
<div class="min-h-screen mt-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    {{-- Header Section --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border-b border-gray-200/50 dark:border-gray-700/50">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Form Fields Manager</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Configure custom fields for your company forms</p>
                    </div>
                </div>
                <button wire:click="newField"
                        class="group relative px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl font-medium hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 inline-block mr-2 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Field
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Fields</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $fields->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Fields</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $fields->where('is_active', true)->count() }}</p>
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
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Text Fields</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $fields->where('type', 'text')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Select Fields</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $fields->where('type', 'select')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Fields List --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Form Fields</h2>
            </div>

            @if($fields->count() > 0)
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($fields->sortBy('order') as $field)
                        <div class="group p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    {{-- Order Badge --}}
                                    <div class="w-10 h-10 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-xl flex items-center justify-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        {{ $field->order }}
                                    </div>

                                    {{-- Field Type Icon --}}
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-md
                                        @if($field->type === 'text') bg-blue-100 dark:bg-blue-900/30
                                        @elseif($field->type === 'textarea') bg-purple-100 dark:bg-purple-900/30
                                        @elseif($field->type === 'select') bg-orange-100 dark:bg-orange-900/30
                                        @else bg-gray-100 dark:bg-gray-900/30 @endif">
                                        @if($field->type === 'text')
                                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                            </svg>
                                        @elseif($field->type === 'textarea')
                                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                            </svg>
                                        @elseif($field->type === 'select')
                                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                            </svg>
                                        @endif
                                    </div>

                                    {{-- Field Info --}}
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $field->label }}</h3>
                                            {{-- Status Badge --}}
                                            @if($field->is_active)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                            <span class="font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $field->name }}</span>
                                            <span class="capitalize">{{ $field->type }}</span>
                                            @if($field->type === 'select' && $field->options)
                                                <span class="text-xs">
                                                    {{ is_array($field->options) ? count($field->options) : count(explode("\n", $field->options)) }} options
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="edit({{ $field->id }})"
                                            class="px-4 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl font-medium hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all duration-200 hover:scale-105 active:scale-95">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    <button wire:click="confirmFieldDeletion({{ $field->id }})"
                                            class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-xl transition-all duration-200 hover:scale-105 active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-16 px-6">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-blue-400 dark:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No form fields yet</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-center mb-6">Create your first custom field to start building dynamic forms</p>
                    <button wire:click="newField"
                            class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl font-medium hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                        Create First Field
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Modern Create/Edit Modal --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block w-full max-w-2xl p-6 my-8 text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl border border-gray-200/50 dark:border-gray-700/50">

                {{-- Modal Header --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $editingId ? 'Edit Field' : 'Create New Field' }}
                        </h3>
                    </div>
                    <button wire:click="$set('showModal', false)"
                            class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Form Fields --}}
                <div class="space-y-6">
                    {{-- Label Field --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Field Label</label>
                        <input wire:model.defer="state.label"
                               type="text"
                               class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                               placeholder="Enter field label">
                        @error('state.label') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Internal Name Field --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Internal Name</label>
                        <input wire:model.defer="state.name"
                               type="text"
                               class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200 font-mono"
                               placeholder="example_field_name">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Use lowercase letters, numbers, and underscores only</p>
                        @error('state.name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Type Field --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Field Type</label>
                        <select wire:model.live="state.type"
                                class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <option value="text">Short Text</option>
                            <option value="textarea">Text Area</option>
                            <option value="select">Select Dropdown</option>
                        </select>
                    </div>

                    {{-- Options Field (for select type) --}}
                    @if(isset($state['type']) && $state['type'] === 'select')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Options</label>
                        <textarea wire:model.defer="state.options"
                                  rows="4"
                                  class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200 resize-none"
                                  placeholder="Option 1&#10;Option 2&#10;Option 3"></textarea>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Enter one option per line</p>
                    </div>
                    @endif

                    {{-- Order and Status Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Order Field --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Display Order</label>
                            <input wire:model.defer="state.order"
                                   type="number"
                                   class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                   placeholder="1">
                            @error('state.order') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Status Toggle --}}
                        <div class="flex items-center space-x-3 mt-8">
                            <input wire:model.defer="state.is_active"
                                   type="checkbox"
                                   class="w-5 h-5 text-blue-600 border-2 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label class="text-sm text-gray-700 dark:text-gray-300">
                                Active (visible in forms)
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center space-x-3 pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                    <button wire:click="save"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl font-medium hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                        {{ $editingId ? 'Update Field' : 'Create Field' }}
                    </button>
                    <button wire:click="$set('showModal', false)"
                            class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 hover:scale-105 active:scale-95">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modern Delete Confirmation Modal --}}
    @if($confirmingFieldDeletion)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block w-full max-w-md p-6 my-8 text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl border border-gray-200/50 dark:border-gray-700/50">

                {{-- Warning Icon --}}
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-red-100 dark:bg-red-900/30 rounded-full">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.238 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>

                {{-- Content --}}
                <div class="text-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Field</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Are you sure you want to delete this field? This action cannot be undone and will remove all associated data.
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex items-center space-x-3">
                    <button wire:click="deleteField"
                            class="flex-1 px-6 py-3 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                        Delete Field
                    </button>
                    <button wire:click="$set('confirmingFieldDeletion', false)"
                            class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 hover:scale-105 active:scale-95">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Gestor de Empresas Moderno --}}
<div class="min-h-screen bg-gradient-to-br mt-12 from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    {{-- Header Section --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border-b border-gray-200/50 dark:border-gray-700/50">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Companies Manager</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your company profiles and information</p>
                    </div>
                </div>
                <button wire:click="newCompany"
                        class="group relative px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-medium hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 inline-block mr-2 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Company
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Companies</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $companies->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Profiles</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $companies->count() }}</p>
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
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">With Data</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $companies->filter(function($c) { return !empty($c->manual_data['elevator_pitch']); })->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Companies List --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Your Companies</h2>
            </div>

            @if($companies->count() > 0)
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($companies as $company)
                        <div class="group p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    {{-- Company Icon --}}
                                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-2xl flex items-center justify-center shadow-md">
                                        <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>

                                    {{-- Company Info --}}
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $company->name }}</h3>
                                            {{-- Status Badge --}}
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Active
                                            </span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                            {{ $company->manual_data['elevator_pitch'] ?? 'No elevator pitch provided. Click edit to add company information.' }}
                                        </p>

                                        {{-- Company Meta Info --}}
                                        <div class="flex items-center space-x-4 mt-3 text-xs text-gray-500 dark:text-gray-400">
                                            <div class="flex items-center space-x-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>Created {{ $company->created_at->format('M j, Y') }}</span>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                <span>Updated {{ $company->updated_at->diffForHumans() }}</span>
                                            </div>
                                            @if($company->manual_data && count($company->manual_data) > 0)
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <span>{{ count($company->manual_data) }} fields</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="edit({{ $company->id }})"
                                            class="px-4 py-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl font-medium hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-all duration-200 hover:scale-105 active:scale-95">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    <button wire:click="confirmCompanyDeletion({{ $company->id }})"
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
                    <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-indigo-400 dark:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No companies yet</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-center mb-6">Create your first company profile to get started with managing your business data</p>
                    <button wire:click="newCompany"
                            class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-medium hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                        Create First Company
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
            <div class="inline-block w-full max-w-3xl p-6 my-8 text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl border border-gray-200/50 dark:border-gray-700/50">

                {{-- Modal Header --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $editing->exists ? 'Edit Company' : 'Create New Company' }}
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
                <div class="space-y-6 max-h-96 overflow-y-auto modal-scroll">
                    @foreach($formFields as $field)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $field->label }}</label>

                            @if($field->type === 'text')
                                <input wire:model.defer="state.{{ $field->name }}"
                                       type="text"
                                       class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                       placeholder="Enter {{ strtolower($field->label) }}">
                            @elseif($field->type === 'textarea')
                                <textarea wire:model.defer="state.{{ $field->name }}"
                                          rows="4"
                                          class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200 resize-none"
                                          placeholder="Enter {{ strtolower($field->label) }}"></textarea>
                            @elseif($field->type === 'select')
                                <select wire:model.defer="state.{{ $field->name }}"
                                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200">
                                    <option value="">Select an option...</option>
                                    @if(is_array($field->options))
                                        @foreach($field->options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            @endif

                            @error('state.' . $field->name) <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    @endforeach
                </div>

                {{-- Actions --}}
                <div class="flex items-center space-x-3 pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                    <button wire:click="save"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-medium hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                        {{ $editing->exists ? 'Update Company' : 'Create Company' }}
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
    @if($confirmingCompanyDeletion)
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
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Company</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Are you sure you want to delete this company? All associated data, including documents, will be permanently removed. This action cannot be undone.
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex items-center space-x-3">
                    <button wire:click="deleteCompany"
                            class="flex-1 px-6 py-3 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                        Delete Company
                    </button>
                    <button wire:click="$set('confirmingCompanyDeletion', false)"
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
    /* Scrollbar personalizado para el modal */
    .modal-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .modal-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .modal-scroll::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.5);
        border-radius: 2px;
    }

    .dark .modal-scroll::-webkit-scrollbar-thumb {
        background: rgba(75, 85, 99, 0.5);
    }

    /* Efectos de hover mejorados */
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .dark .hover-lift:hover {
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
    }

    /* Animaciones suaves */
    .fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive mejoras */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(1, 1fr);
        }

        .company-actions {
            flex-direction: column;
            gap: 0.5rem;
        }

        .modal-content {
            margin: 1rem;
            width: calc(100% - 2rem);
        }
    }

    /* Mejoras de accesibilidad */
    .focus-visible:focus {
        outline: 2px solid #6366f1;
        outline-offset: 2px;
    }

    /* Transiciones suaves globales */
    * {
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Efectos de pulsación para elementos interactivos */
    .interactive-element:active {
        transform: scale(0.95);
    }

    /* Gradientes animados */
    .gradient-animation {
        background: linear-gradient(-45deg, #6366f1, #8b5cf6, #ec4899, #f59e0b);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
    }

    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    /* Estados de carga */
    .loading-shimmer {
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        0% {
            background-position: -200% 0;
        }
        100% {
            background-position: 200% 0;
        }
    }

    /* Mejoras para elementos de formulario */
    .form-input:focus {
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* Estilos para badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        line-height: 1;
    }

    /* Animaciones de entrada para las tarjetas */
    .card-enter {
        animation: cardEnter 0.3s ease-out;
    }

    @keyframes cardEnter {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
</style>
</div>



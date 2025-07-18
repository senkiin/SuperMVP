{{-- Sidebar moderno con diseño contemporáneo --}}
<div x-data="{ sidebarExpanded: $persist(true) }"
     :class="sidebarExpanded ? 'w-80' : 'w-16'"
     class="flex-shrink-0 h-full mt-16 flex flex-col bg-white dark:bg-gray-950 border-r border-gray-200 dark:border-gray-800 transition-all duration-300 ease-in-out">
    @auth
        {{-- Header del sidebar --}}
        <div class="flex-shrink-0 p-4 border-b border-gray-100 dark:border-gray-800 bg-gradient-to-r from-white to-gray-50 dark:from-gray-950 dark:to-gray-900">
            <div class="flex items-center justify-between">
                <div x-show="sidebarExpanded"
                     x-transition:enter="transition ease-out duration-200 delay-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white truncate">Conversations</h2>
                </div>

                {{-- Botones siempre visibles --}}
                <div class="flex items-center space-x-2">
                    {{-- Botón de nueva conversación --}}
                    <button
                        x-show="sidebarExpanded"
                        x-transition:enter="transition ease-out duration-200 delay-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        wire:click="newConversation"
                        class="group relative p-2.5 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-all duration-200 hover:scale-105 active:scale-95"
                        title="New Conversation">
                        <svg class="w-5 h-5 transition-transform group-hover:rotate-90" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        <div class="absolute -top-2 -right-2 w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    </button>

                    {{-- Botón de nueva conversación cuando está colapsado --}}
                    <button
                        x-show="!sidebarExpanded"
                        x-transition:enter="transition ease-out duration-200 delay-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        wire:click="newConversation"
                        class="group relative p-2.5 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-all duration-200 hover:scale-105 active:scale-95"
                        title="New Conversation">
                        <svg class="w-5 h-5 transition-transform group-hover:rotate-90" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        <div class="absolute -top-2 -right-2 w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    </button>

                    {{-- Botón de colapsar/expandir - SIEMPRE VISIBLE --}}
                    <button @click="sidebarExpanded = !sidebarExpanded"
                            class="p-2.5 text-gray-500 dark:text-gray-400 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-800 transition-all duration-200 hover:scale-105 z-50"
                            title="Toggle Sidebar">
                        <svg :class="{'rotate-180': !sidebarExpanded}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Lista de conversaciones --}}
        <div x-show="sidebarExpanded"
             x-transition:enter="transition ease-out duration-200 delay-100"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-700 scrollbar-track-transparent">
            <div class="p-4 space-y-2">
                @forelse($conversations as $conv)
                <div class="group relative bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 hover:border-indigo-200 dark:hover:border-indigo-800 hover:shadow-md dark:hover:shadow-gray-900/50 transition-all duration-200 hover:-translate-y-0.5">
                    <div wire:click="selectConversation({{ $conv->id }})" class="p-4 cursor-pointer">
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-indigo-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity"></div>

                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0 pr-4">
                                <p class="font-medium text-gray-900 dark:text-white truncate text-sm mb-1">
                                    {{ $conv->title }}
                                </p>
                                <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $conv->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div class="flex-shrink-0 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs px-2 py-1 rounded-full">
                                {{ $conv->messages_count ?? 0 }}
                            </div>
                        </div>
                    </div>

                    {{-- Botón de eliminar --}}
                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-all duration-200">
                        @if($confirmingDeletion === $conv->id)
                            <div class="flex items-center space-x-1 bg-white dark:bg-gray-900 rounded-lg p-1 shadow-lg border border-gray-200 dark:border-gray-700">
                                <button wire:click="deleteConversation({{ $conv->id }})" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-md transition-colors" title="Confirm delete">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                                <button wire:click="cancelDelete" class="p-1.5 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors" title="Cancel">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        @else
                            <button wire:click="confirmDelete({{ $conv->id }})" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-md transition-all duration-200" title="Delete conversation">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        @endif
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-12 px-6 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-indigo-400 dark:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No conversations yet</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Start your first conversation and it will appear here</p>
                    <button wire:click="newConversation" class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg font-medium hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                        Start Chatting
                    </button>
                </div>
                @endforelse
            </div>
        </div>
    @else
        {{-- Estado no autenticado --}}
        <div x-show="sidebarExpanded"
             x-transition:enter="transition ease-out duration-200 delay-100"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="h-full flex items-center justify-center p-6">
            <div class="text-center max-w-sm">
                <div class="relative mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-10 h-10 text-indigo-500 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">History Unavailable</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                    Sign in to save your conversations and access them from any device
                </p>
                <div class="space-y-3">
                    <a href="{{ route('login') }}" class="block w-full px-4 py-3 text-sm font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="block w-full px-4 py-3 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-all duration-200 hover:scale-105 active:scale-95">
                        Create Account
                    </a>
                </div>
            </div>
        </div>
    @endauth

{{-- Estilos del sidebar --}}
<style>
    .scrollbar-thin::-webkit-scrollbar { width: 4px; }
    .scrollbar-thumb-gray-300::-webkit-scrollbar-thumb { background-color: rgb(209 213 219); border-radius: 9999px; }
    .dark .scrollbar-thumb-gray-700::-webkit-scrollbar-thumb { background-color: rgb(55 65 81); }
    .scrollbar-track-transparent::-webkit-scrollbar-track { background: transparent; }
</style>

{{-- Alpine.js persist plugin para recordar el estado del sidebar --}}
<script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>

</div>

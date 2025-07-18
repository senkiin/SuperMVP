{{-- Chat moderno para usuarios invitados --}}
<div x-data="{
        chat: null,
        init() {
            this.chat = this.$refs.chat;
            this.scrollToBottom();

            // Escucha los eventos de Livewire para hacer scroll cuando se actualice el DOM
            Livewire.on('messages-updated', () => {
                this.$nextTick(() => this.scrollToBottom());
            });
        },
        scrollToBottom() {
            if (!this.chat) return;
            this.chat.scrollTop = this.chat.scrollHeight;
        }
    }"
    x-init="init()"
    class="h-full mt-14 flex flex-col bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 relative overflow-hidden">

    {{-- Patrón de fondo sutil --}}
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/30 to-purple-50/30 dark:from-indigo-900/10 dark:to-purple-900/10 opacity-60"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_25%_25%,rgba(99,102,241,0.1),transparent_50%)] dark:bg-[radial-gradient(circle_at_25%_25%,rgba(99,102,241,0.05),transparent_50%)]"></div>

    {{-- Header elegante para invitados --}}
    <div class="relative z-10 h-20 px-8 py-4 border-b border-gray-200/50 dark:border-gray-700/50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl">
        <div class="flex justify-between items-center h-full">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/25">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">AI Assistant</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Try our AI without registration</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-700">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Guest Mode
                </span>
            </div>

            <div class="flex items-center space-x-3">
                <button wire:click="clearConversation"
                        class="p-3 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-white/60 dark:hover:bg-gray-800/60 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 hover:scale-105 backdrop-blur-sm border border-transparent hover:border-gray-200/50 dark:hover:border-gray-700/50"
                        title="New conversation">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Área de mensajes moderna --}}
    <div x-ref="chat" class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-indigo-300 dark:scrollbar-thumb-indigo-700 scrollbar-track-transparent relative z-10">
        <div class="px-8 py-8 space-y-8 max-w-6xl mx-auto" style="padding-bottom: 160px;">
            {{-- Mensaje de bienvenida para invitados --}}
            @if(empty($messages))
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Welcome to AI Assistant</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">Ask me anything! I'm here to help you with questions, tasks, and conversations.</p>
                    <div class="flex flex-wrap justify-center gap-3 mb-8">
                        <button wire:click="$set('newMessage', 'What can you help me with?')"
                                class="px-4 py-2 bg-white/60 dark:bg-gray-800/60 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-white/80 dark:hover:bg-gray-700/80 transition-all duration-200 hover:scale-105 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50">
                            What can you help me with?
                        </button>
                        <button wire:click="$set('newMessage', 'Tell me a joke')"
                                class="px-4 py-2 bg-white/60 dark:bg-gray-800/60 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-white/80 dark:hover:bg-gray-700/80 transition-all duration-200 hover:scale-105 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50">
                            Tell me a joke
                        </button>
                        <button wire:click="$set('newMessage', 'Explain quantum computing')"
                                class="px-4 py-2 bg-white/60 dark:bg-gray-800/60 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-white/80 dark:hover:bg-gray-700/80 transition-all duration-200 hover:scale-105 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50">
                            Explain quantum computing
                        </button>
                    </div>
                    <div class="bg-gradient-to-r from-indigo-500/10 to-purple-500/10 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl p-6 border border-indigo-200/50 dark:border-indigo-700/50">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">💡 Want More Features?</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Sign up to save your conversations, access advanced settings, and unlock premium features!</p>
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-medium hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                            Create Free Account
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

            @foreach ($messages as $message)
                <div class="flex items-start gap-6 @if($message['sender'] == 'user') flex-row-reverse @endif">
                    {{-- Avatar mejorado --}}
                    @if($message['sender'] == 'ai')
                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl text-white font-bold text-sm shadow-lg shadow-indigo-500/25 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                    @else
                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-gray-600 to-gray-700 rounded-2xl text-white font-bold text-sm shadow-lg shadow-gray-500/25 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif

                    {{-- Mensaje rediseñado --}}
                    <div class="flex-1 max-w-4xl">
                        <div class="@if($message['sender'] == 'user') bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-3xl rounded-br-lg shadow-lg shadow-indigo-500/25 @else bg-white/80 dark:bg-gray-800/80 text-gray-900 dark:text-gray-100 rounded-3xl rounded-bl-lg shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 @endif px-6 py-4 transition-all duration-200 hover:shadow-xl">
                            <div class="text-base leading-relaxed prose dark:prose-invert max-w-none @if($message['sender'] == 'user') prose-invert @endif">
                                {!! \Illuminate\Support\Str::markdown($message['content']) !!}
                            </div>
                        </div>
                        <div class="flex items-center @if($message['sender'] == 'user') justify-end @endif mt-2 px-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                @if($message['sender'] == 'user') You @else AI Assistant @endif
                                • {{ \Carbon\Carbon::parse($message['timestamp'])->format('H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Indicador de carga moderno --}}
            @if($loading)
                <div class="flex items-start gap-6">
                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl text-white font-bold text-sm shadow-lg shadow-indigo-500/25 flex-shrink-0">
                        <svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 max-w-4xl">
                        <div class="bg-white/80 dark:bg-gray-800/80 rounded-3xl rounded-bl-lg shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex space-x-2">
                                    <div class="w-3 h-3 bg-indigo-500 rounded-full animate-bounce"></div>
                                    <div class="w-3 h-3 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                                    <div class="w-3 h-3 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">AI is thinking...</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Barra de input moderna y fija --}}
    <div class="absolute bottom-0 left-0 right-0 z-20 p-6 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-t border-gray-200/50 dark:border-gray-700/50">
        <div class="max-w-6xl mx-auto">
            <form wire:submit="sendMessage" class="relative">
                <div class="flex items-end space-x-4">
                    <div class="flex-1 relative">
                        <textarea
                            wire:model="newMessage"
                            placeholder="Ask me anything..."
                            class="w-full px-6 py-4 pr-16 border-2 border-gray-200 dark:border-gray-700 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800/50 dark:text-gray-200 resize-none backdrop-blur-sm transition-all duration-200 hover:shadow-lg"
                            rows="1"
                            style="min-height: 56px; max-height: 120px;"
                            autocomplete="off"
                            wire:loading.attr="disabled"
                            x-data="{ resize: function() { this.$el.style.height = 'auto'; this.$el.style.height = Math.min(this.$el.scrollHeight, 120) + 'px'; } }"
                            x-on:input="resize"
                            x-init="resize"></textarea>

                        {{-- Botón de envío integrado --}}
                        <button
                            type="submit"
                            class="absolute right-3 bottom-3 w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl flex items-center justify-center"
                            wire:loading.attr="disabled"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>

            {{-- Información para invitados mejorada --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-4 space-y-2 sm:space-y-0">
                <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.238 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <span>Public chat without history • Messages are not saved</span>
                </div>

                <div class="flex items-center space-x-4 text-xs">
                    <span class="text-gray-500 dark:text-gray-400">Press</span>
                    <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs">Enter</kbd>
                    <span class="text-gray-500 dark:text-gray-400">to send</span>
                    <span class="text-gray-300 dark:text-gray-600">•</span>
                    <a href="{{ route('register') }}"
                       class="text-indigo-500 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium transition-colors">
                        Want advanced features? Sign up here →
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- Estilos adicionales --}}
<style>
    /* Scrollbar personalizado */
    .scrollbar-thin::-webkit-scrollbar { width: 4px; }
    .scrollbar-thumb-indigo-300::-webkit-scrollbar-thumb { background-color: rgb(165 180 252); border-radius: 9999px; }
    .dark .scrollbar-thumb-indigo-700::-webkit-scrollbar-thumb { background-color: rgb(67 56 202); }
    .scrollbar-track-transparent::-webkit-scrollbar-track { background: transparent; }

    /* Animaciones suaves */
    .fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Efectos glassmorphism */
    .glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dark .glass {
        background: rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Auto-resize textarea */
    textarea {
        resize: none;
        overflow: hidden;
    }

    /* Mejoras responsive */
    @media (max-width: 640px) {
        .suggestion-buttons {
            flex-direction: column;
            width: 100%;
        }

        .mobile-stack {
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
        }
    }
</style>
</div>



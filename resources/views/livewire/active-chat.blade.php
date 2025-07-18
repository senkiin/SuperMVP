{{-- Chat principal moderno con expansión automática --}}
<div x-data="{
        showSettings: false,
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
    class="flex-1 flex mt-16 transition-all duration-300 ease-in-out">

    @if ($activeConversation)
        {{-- Área principal del chat con diseño moderno --}}
        <div class="flex-1 flex flex-col bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 relative overflow-hidden">
            {{-- Patrón de fondo sutil --}}
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/30 to-purple-50/30 dark:from-indigo-900/10 dark:to-purple-900/10 opacity-60"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_25%_25%,rgba(99,102,241,0.1),transparent_50%)] dark:bg-[radial-gradient(circle_at_25%_25%,rgba(99,102,241,0.05),transparent_50%)]"></div>

            {{-- Header mejorado con gradiente --}}
            <div class="relative z-10 h-20 px-8 py-4 border-b border-gray-200/50 dark:border-gray-700/50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl">
                <div class="flex justify-between items-center h-full">
                    @if($isEditingTitle)
                        <div class="flex items-center space-x-4 flex-1 pr-4">
                            <input
                                wire:model="editingTitle"
                                wire:keydown.enter="saveTitle"
                                wire:keydown.escape="cancelEditingTitle"
                                type="text"
                                class="flex-1 px-4 py-2 text-xl font-semibold bg-white/50 dark:bg-gray-800/50 border-2 border-indigo-300 dark:border-indigo-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-800 dark:text-gray-200 backdrop-blur-sm"
                                autofocus>
                            <div class="flex items-center space-x-2">
                                <button wire:click="saveTitle" class="p-2.5 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-xl transition-all duration-200 hover:scale-105" title="Save">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                                <button wire:click="cancelEditingTitle" class="p-2.5 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-xl transition-all duration-200 hover:scale-105" title="Cancel">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-4 flex-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/25">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <button wire:click="startEditingTitle" class="group text-left w-full">
                                    <h1 class="text-xl font-bold text-gray-900 dark:text-white truncate pr-4 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        {{ $activeConversation->title }}
                                    </h1>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 group-hover:text-indigo-500 dark:group-hover:text-indigo-300">
                                        Click to edit title • {{ $activeConversation->messages()->count() }} messages
                                    </p>
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center space-x-3">
                        <div class="flex items-center space-x-2 px-4 py-2 bg-white/60 dark:bg-gray-800/60 rounded-xl backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">Online</span>
                        </div>
                        <button @click="showSettings = !showSettings" class="p-3 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-white/60 dark:hover:bg-gray-800/60 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-200 hover:scale-105 backdrop-blur-sm border border-transparent hover:border-gray-200/50 dark:hover:border-gray-700/50" title="Chat Settings">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Área de mensajes rediseñada --}}
            <div x-ref="chat" class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-indigo-300 dark:scrollbar-thumb-indigo-700 scrollbar-track-transparent relative z-10" style="height: calc(100vh - 240px);">
                <div class="px-8 py-8 space-y-8 max-w-5xl mx-auto">
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
                                        @if($message['sender'] == 'user') You @else Assistant @endif
                                        • {{ now()->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Indicador de carga mejorado --}}
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
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Assistant is thinking...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Barra de input rediseñada --}}
            <div class="relative z-10 px-8 py-6 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-t border-gray-200/50 dark:border-gray-700/50">
                <div class="max-w-5xl mx-auto">
                    <form wire:submit="sendMessage" class="relative">
                        <div class="flex items-end space-x-4">
                            <div class="flex-1 relative">
                                <textarea
                                    wire:model="newMessage"
                                    placeholder="Type your message here..."
                                    class="w-full px-6 py-4 pr-16 border-2 border-gray-200 dark:border-gray-700 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800/50 dark:text-gray-200 resize-none backdrop-blur-sm transition-all duration-200 hover:shadow-lg"
                                    rows="1"
                                    style="min-height: 56px; max-height: 200px;"
                                    autocomplete="off"
                                    wire:loading.attr="disabled"
                                    x-data="{ resize: function() { this.$el.style.height = 'auto'; this.$el.style.height = this.$el.scrollHeight + 'px'; } }"
                                    x-on:input="resize"
                                    x-init="resize"></textarea>

                                {{-- Botón de envío integrado --}}
                                <button
                                    type="submit"
                                    class="absolute right-3 bottom-3 w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl flex items-center justify-center"
                                    wire:loading.attr="disabled"
                                    :disabled="!newMessage || newMessage.trim() === ''"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Botones adicionales --}}
                            <div class="flex items-center space-x-2">
                                <button type="button" class="p-3 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-white/60 dark:hover:bg-gray-800/60 rounded-xl transition-all duration-200 hover:scale-105 backdrop-blur-sm border border-transparent hover:border-gray-200/50 dark:hover:border-gray-700/50" title="Attach file">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                </button>
                                <button type="button" class="p-3 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-white/60 dark:hover:bg-gray-800/60 rounded-xl transition-all duration-200 hover:scale-105 backdrop-blur-sm border border-transparent hover:border-gray-200/50 dark:hover:border-gray-700/50" title="Voice message">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Texto de ayuda mejorado --}}
                    <div class="flex items-center justify-center mt-4 space-x-6 text-xs text-gray-500 dark:text-gray-400">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span>AI assistant can make mistakes. Consider checking important information.</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span>Press</span>
                            <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs">Enter</kbd>
                            <span>to send</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel de settings mejorado --}}
        <div x-show="showSettings"
             x-transition:enter="transition ease-in-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed top-0 right-0 w-96 h-screen bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl border-l border-gray-200/50 dark:border-gray-700/50 flex flex-col overflow-y-auto z-50 shadow-2xl"
             @click.away="showSettings = false"
             style="display: none;">

            {{-- Header del panel --}}
            <div class="flex items-center justify-between p-6 border-b border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Chat Settings</h3>
                </div>
                <button @click="showSettings = false" class="p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Contenido del panel --}}
            <div class="flex-1 p-6 space-y-8">
                {{-- Sección de contexto de empresa --}}
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Company Context</h4>
                    </div>
                    <select wire:model.live="settings.user_company_id" class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800/50 dark:text-gray-200 transition-all duration-200">
                        @if($companies->count() > 0)
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        @else
                            <option value="">No company available</option>
                        @endif
                    </select>
                </div>

                {{-- Sección de fuente de datos --}}
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Data Source</h4>
                    </div>
                    <div class="space-y-3">
                        <label class="flex items-center space-x-3 p-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 cursor-pointer">
                            <input type="radio" wire:model.live="settings.data_source" value="both" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Documents & Manual Data</span>
                        </label>
                        <label class="flex items-center space-x-3 p-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 cursor-pointer">
                            <input type="radio" wire:model.live="settings.data_source" value="documents" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Documents Only</span>
                        </label>
                        <label class="flex items-center space-x-3 p-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 cursor-pointer">
                            <input type="radio" wire:model.live="settings.data_source" value="manual" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Manual Data Only</span>
                        </label>
                    </div>
                </div>

                {{-- Resto del contenido del panel de settings --}}
                @if($this->showDocumentSelection)
                    <div class="space-y-4">
                        <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent"></div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Select Documents</h4>
                            </div>
                            <div class="flex space-x-2">
                                <button wire:click="selectAllDocuments" class="px-3 py-1.5 text-xs font-medium bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-lg hover:bg-indigo-200 dark:hover:bg-indigo-900/50 transition-all duration-200 hover:scale-105">
                                    Select All
                                </button>
                                <button wire:click="deselectAllDocuments" class="px-3 py-1.5 text-xs font-medium bg-gray-100 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 hover:scale-105">
                                    Clear All
                                </button>
                            </div>
                        </div>

                        @if($documents->count() > 0)
                            <div class="max-h-64 overflow-y-auto space-y-2 border-2 border-gray-200 dark:border-gray-700 rounded-xl p-4 bg-gray-50/50 dark:bg-gray-800/30 backdrop-blur-sm">
                                @foreach($documents as $document)
                                    <label class="flex items-start space-x-3 p-3 rounded-xl hover:bg-white dark:hover:bg-gray-700/50 transition-all duration-200 cursor-pointer border border-transparent hover:border-gray-200 dark:hover:border-gray-600">
                                        <input
                                            type="checkbox"
                                            wire:click="toggleDocument({{ $document->id }})"
                                            @if(in_array($document->id, $selectedDocuments)) checked @endif
                                            class="mt-1 w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-200 truncate">
                                                {{ $document->original_filename }}
                                            </p>
                                            <div class="flex items-center space-x-2 mt-1">
                                                @if($document->category)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-800">
                                                        {{ $document->category->name }}
                                                    </span>
                                                @endif
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $document->created_at->format('M j, Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/50 px-3 py-2 rounded-lg">
                                <span>{{ count($selectedDocuments) }} of {{ $documents->count() }} documents selected</span>
                                <div class="flex items-center space-x-1">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span>Ready</span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium">No documents available</p>
                                <p class="text-xs mt-1">Upload and analyze documents to use them in your conversations</p>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Búsqueda avanzada --}}
                <div class="space-y-4">
                    <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent"></div>

                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Advanced Search</h4>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country</label>
                            <input
                                id="search_country"
                                type="text"
                                class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800/50 dark:text-gray-200 transition-all duration-200"
                                wire:model.defer="settings.search_country"
                                placeholder="e.g., Spain, USA"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Industry</label>
                            <input
                                id="search_industry"
                                type="text"
                                class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800/50 dark:text-gray-200 transition-all duration-200"
                                wire:model.defer="settings.search_industry"
                                placeholder="e.g., Technology, Healthcare"
                            />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer del panel --}}
            <div class="p-6 border-t border-gray-200/50 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-800/30">
                <button
                    wire:click="saveSettings"
                    class="w-full px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-medium hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl"
                >
                    Save Settings
                </button>
            </div>
        </div>
    @else
        {{-- Estado vacío mejorado --}}
        <div class="flex-1 flex items-center justify-center bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 relative overflow-hidden">
            {{-- Patrón de fondo para estado vacío --}}
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/30 to-purple-50/30 dark:from-indigo-900/10 dark:to-purple-900/10 opacity-60"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(99,102,241,0.1),transparent_50%)] dark:bg-[radial-gradient(circle_at_50%_50%,rgba(99,102,241,0.05),transparent_50%)]"></div>

            <div class="text-center relative z-10 max-w-md mx-auto px-8">
                <div class="relative mb-8">
                    <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-3xl flex items-center justify-center mx-auto shadow-lg">
                        <svg class="w-12 h-12 text-indigo-500 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Ready to Chat!</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                    Select a conversation from the sidebar or start a new one to begin chatting with your AI assistant.
                </p>

                <div class="flex flex-col space-y-3">
                    <button
                        wire:click="newConversation"
                        class="w-full px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-medium hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl"
                    >
                        Start New Conversation
                    </button>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Or choose from your conversation history
                    </p>
                </div>
            </div>
        </div>
    @endif
    {{-- Estilos adicionales para el scroll personalizado --}}
<style>
    .scrollbar-thin::-webkit-scrollbar {
        width: 4px;
    }

    .scrollbar-thumb-indigo-300::-webkit-scrollbar-thumb {
        background-color: rgb(165 180 252);
        border-radius: 9999px;
    }

    .dark .scrollbar-thumb-indigo-700::-webkit-scrollbar-thumb {
        background-color: rgb(67 56 202);
    }

    .scrollbar-track-transparent::-webkit-scrollbar-track {
        background: transparent;
    }

    /* Animación para el textarea */
    textarea {
        transition: height 0.2s ease;
    }

    /* Efectos de glassmorphism */
    .backdrop-blur-xl {
        backdrop-filter: blur(16px);
    }

    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
    }
</style>
</div>



{{-- Chat para usuarios invitados - temporal, sin base de datos --}}
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
    class="h-full flex flex-col bg-white dark:bg-gray-900 relative">

    {{-- Header simple para invitados --}}
    <div class="h-16 p-4 border-b dark:border-gray-700 bg-white dark:bg-gray-900 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <h1 class="font-semibold text-lg text-gray-800 dark:text-gray-200">
                AI Assistant
            </h1>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                Guest Mode
            </span>
        </div>

        <div class="flex items-center space-x-3">
            <button wire:click="clearConversation" class="p-2 rounded-md text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-colors" title="New conversation">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </button>

            <a href="{{ route('register') }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Sign Up
            </a>

            <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-xs font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Sign In
            </a>
        </div>
    </div>

    {{-- Área de mensajes con scroll independiente --}}
    <div x-ref="chat" class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900/50" style="scrollbar-width: thin; scrollbar-color: #6b7280 #f3f4f6;">
        <div class="p-6 space-y-6 max-w-4xl mx-auto" style="padding-bottom: 120px;">
            @foreach ($messages as $message)
                <div class="flex items-start gap-3 @if($message['sender'] == 'user') flex-row-reverse @endif">
                    @if($message['sender'] == 'ai')
                        <div class="flex items-center justify-center size-8 bg-indigo-500 rounded-full text-white font-bold text-xs shrink-0">AI</div>
                    @else
                        <div class="flex items-center justify-center size-8 bg-gray-500 rounded-full text-white font-bold text-xs shrink-0">YOU</div>
                    @endif
                    <div class="max-w-2xl px-4 py-3 rounded-lg @if($message['sender'] == 'user') bg-indigo-600 text-white rounded-br-none @else bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-bl-none shadow-sm @endif">
                        <div class="text-sm prose dark:prose-invert max-w-none">{!! \Illuminate\Support\Str::markdown($message['content']) !!}</div>
                        <div class="text-xs opacity-70 mt-2">
                            {{ \Carbon\Carbon::parse($message['timestamp'])->format('H:i') }}
                        </div>
                    </div>
                </div>
            @endforeach

            @if($loading)
                <div class="flex items-start gap-3">
                    <div class="flex items-center justify-center size-8 bg-indigo-500 rounded-full text-white font-bold text-xs shrink-0">AI</div>
                    <div class="max-w-lg px-4 py-3 rounded-lg bg-white dark:bg-gray-700 shadow-sm">
                        <div class="flex items-center space-x-1.5">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Barra de input fija más arriba --}}
    <div class="absolute bottom-0 left-0 right-0 p-4 bg-white dark:bg-gray-900 border-t dark:border-gray-700 shadow-lg">
        <div class="max-w-3xl mx-auto">
            <form wire:submit="sendMessage" class="flex items-center space-x-3">
                <input
                    wire:model="newMessage"
                    type="text"
                    placeholder="Type your question..."
                    class="flex-1 w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                    autocomplete="off"
                    wire:loading.attr="disabled">
                <button type="submit" class="inline-flex items-center justify-center size-12 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition-colors" wire:loading.attr="disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                    </svg>
                </button>
            </form>
            <div class="flex justify-between items-center mt-2 px-4">
                <p class="text-xs text-gray-400">
                    Public chat without history. Messages are not saved.
                </p>
                <p class="text-xs text-indigo-500">
                    <a href="{{ route('register') }}" class="hover:text-indigo-700">Want advanced features? Sign up here</a>
                </p>
            </div>
        </div>
    </div>
</div>

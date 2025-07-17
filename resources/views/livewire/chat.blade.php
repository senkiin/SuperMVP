<div x-data="{
        chat: null,
        init() {
            this.chat = this.$refs.chat;
            this.scrollToBottom();
        },
        scrollToBottom() {
            if (!this.chat) return;
            this.chat.scrollTop = this.chat.scrollHeight;
        }
    }"
    x-init="init()"
    @messages-updated.window="scrollToBottom()"
    class="flex flex-col h-[85vh] max-h-[85vh] bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">

    <!-- Cabecera del Chat -->
    <div class="p-4 border-b dark:border-gray-700 flex items-center space-x-3 shrink-0">
        <div class="relative flex items-center justify-center size-10 bg-indigo-500 rounded-full text-white font-bold">
            AI
            <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-green-400 ring-2 ring-white dark:ring-gray-800"></span>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Asistente de Negocio</h2>
            <p class="text-xs text-green-600 dark:text-green-400">Online</p>
        </div>
    </div>

    <!-- Contenedor de Mensajes -->
    <div x-ref="chat" class="flex-1 p-6 space-y-6 overflow-y-auto">
        @foreach ($messages as $message)
            <div class="flex items-start gap-3 @if($message['sender'] == 'user') flex-row-reverse @endif">
                @if($message['sender'] == 'ai')
                    <div class="flex items-center justify-center size-8 bg-indigo-500 rounded-full text-white font-bold text-xs shrink-0">AI</div>
                @endif
                <div class="max-w-lg px-4 py-3 rounded-lg @if($message['sender'] == 'user') bg-indigo-600 text-white rounded-br-none @else bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-bl-none @endif">
                    <p class="text-sm prose dark:prose-invert max-w-none">{!! \Illuminate\Support\Str::markdown($message['content']) !!}</p>
                    @if (isset($message['show_button']) && $message['show_button'])
                        <div class="mt-4">
                            <a href="{{ route('user.documents') }}" wire:navigate class="inline-block bg-white text-indigo-600 font-bold py-2 px-4 rounded-md text-xs hover:bg-gray-100 shadow-sm transition-colors">
                                Subir Documentos
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        @if($loading)
             <div class="flex items-start gap-3">
                <div class="flex items-center justify-center size-8 bg-indigo-500 rounded-full text-white font-bold text-xs shrink-0">AI</div>
                <div class="max-w-lg px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700">
                   <div class="flex items-center space-x-1.5">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
                   </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Input para Escribir Mensaje -->
    <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-t dark:border-gray-700 shrink-0">
        <form wire:submit="sendMessage" class="flex items-center space-x-3">
            <input 
                wire:model="newMessage"
                type="text" 
                placeholder="Escribe tu pregunta aquí..." 
                class="flex-1 w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                autocomplete="off"
                wire:loading.attr="disabled">
            <button type="submit" class="inline-flex items-center justify-center size-10 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition-colors shrink-0" wire:loading.attr="disabled">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path d="M0 0h24v24H0V0z" fill="none"/>
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
            </button>
        </form>
    </div>
</div>

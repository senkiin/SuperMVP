{{-- Chat principal con áreas independientes --}}
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
    class="h-full flex">

    @if ($activeConversation)
        {{-- Área principal del chat --}}
        <div class="flex-1 flex flex-col bg-white dark:bg-gray-900">
            
            {{-- Header fijo del chat --}}
            <div class="h-16 p-4 border-b dark:border-gray-700 bg-white dark:bg-gray-900 flex justify-between items-center">
                @if($isEditingTitle)
                    <div class="flex items-center space-x-2 flex-1 pr-4">
                        <input 
                            wire:model="editingTitle" 
                            wire:keydown.enter="saveTitle"
                            wire:keydown.escape="cancelEditingTitle"
                            type="text" 
                            class="flex-1 px-2 py-1 text-lg font-semibold bg-transparent border-b-2 border-indigo-500 focus:outline-none text-gray-800 dark:text-gray-200"
                            autofocus>
                        <button wire:click="saveTitle" class="p-1 text-green-600 hover:bg-green-100 dark:hover:bg-green-900 rounded" title="Save">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                        <button wire:click="cancelEditingTitle" class="p-1 text-red-600 hover:bg-red-100 dark:hover:bg-red-900 rounded" title="Cancel">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @else
                    <button wire:click="startEditingTitle" class="font-semibold text-lg text-gray-800 dark:text-gray-200 truncate pr-4 hover:bg-gray-100 dark:hover:bg-gray-800 px-2 py-1 rounded transition-colors text-left flex-1" title="Click to edit title">
                        {{ $activeConversation->title }}
                    </button>
                @endif
                
                <button @click="showSettings = !showSettings" class="p-2 rounded-md text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-colors" title="Chat Settings">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" /></svg>
                </button>
            </div>

            {{-- Área de mensajes con scroll independiente --}}
            <div x-ref="chat" class="overflow-y-auto bg-gray-50 dark:bg-gray-900/50" style="height: calc(100vh - 200px); scrollbar-width: thin; scrollbar-color: #6b7280 #f3f4f6;">
                <div class="p-6 space-y-6">
                    @foreach ($messages as $message)
                        <div class="flex items-start gap-3 @if($message['sender'] == 'user') flex-row-reverse @endif">
                            @if($message['sender'] == 'ai')
                                <div class="flex items-center justify-center size-8 bg-indigo-500 rounded-full text-white font-bold text-xs shrink-0">AI</div>
                            @endif
                            <div class="max-w-2xl px-4 py-3 rounded-lg @if($message['sender'] == 'user') bg-indigo-600 text-white rounded-br-none @else bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-bl-none shadow-sm @endif">
                                <div class="text-sm prose dark:prose-invert max-w-none">{!! \Illuminate\Support\Str::markdown($message['content']) !!}</div>
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

            {{-- Barra de input fija en la parte inferior --}}
            <div class="h-24 p-4 bg-white dark:bg-gray-900 border-t dark:border-gray-700">
                <div class="max-w-3xl mx-auto">
                    <form wire:submit="sendMessage" class="flex items-center space-x-3">
                        <input 
                            wire:model="newMessage"
                            type="text" 
                            placeholder="Ask your assistant..." 
                            class="flex-1 w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            autocomplete="off"
                            wire:loading.attr="disabled">
                        <button type="submit" class="inline-flex items-center justify-center size-12 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition-colors" wire:loading.attr="disabled">
 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path d="M0 0h24v24H0V0z" fill="none"/>
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>                        </button>
                    </form>
                    <p class="text-xs text-center text-gray-400 mt-2 px-4">
                        AI assistant can make mistakes. Consider checking important information.
                    </p>
                </div>
            </div>
        </div>

        {{-- Panel de settings (overlay) --}}
        <div x-show="showSettings" 
             x-transition:enter="transition ease-in-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed top-0 right-0 w-96 h-screen bg-white dark:bg-gray-800 border-l dark:border-gray-700 p-6 flex flex-col space-y-6 overflow-y-auto z-50 shadow-xl"
             @click.away="showSettings = false"
             style="display: none;">
            
            <div class="flex justify-between items-center">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Chat Settings</h3>
                <button @click="showSettings = false" class="p-2 rounded-md text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                </button>
            </div>
            
            <div>
                <x-label value="Company Context" />
                <select wire:model="settings.user_company_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-label value="Data Source" />
                <div class="mt-2 space-y-2 text-sm text-gray-700 dark:text-gray-300">
                    <label class="flex items-center"><input type="radio" wire:model="settings.data_source" value="both" class="form-radio text-indigo-600 dark:bg-gray-900 border-gray-300 dark:border-gray-700"> <span class="ml-2">Documents & Manual Data</span></label>
                    <label class="flex items-center"><input type="radio" wire:model="settings.data_source" value="documents" class="form-radio text-indigo-600 dark:bg-gray-900 border-gray-300 dark:border-gray-700"> <span class="ml-2">Documents Only</span></label>
                    <label class="flex items-center"><input type="radio" wire:model="settings.data_source" value="manual" class="form-radio text-indigo-600 dark:bg-gray-900 border-gray-300 dark:border-gray-700"> <span class="ml-2">Manual Data Only</span></label>
                </div>
            </div>

            <x-section-border />

            <h4 class="font-semibold text-gray-800 dark:text-gray-200">Advanced Search</h4>
            <div>
                <x-label for="search_country" value="Country" />
                <x-input id="search_country" type="text" class="mt-1 block w-full" wire:model.defer="settings.search_country" placeholder="e.g., Spain, USA" />
            </div>
            <div>
                <x-label for="search_industry" value="Industry" />
                <x-input id="search_industry" type="text" class="mt-1 block w-full" wire:model.defer="settings.search_industry" placeholder="e.g., Technology, Healthcare" />
            </div>
            
            <div class="flex-grow"></div>
            <div class="flex justify-end">
                <x-button wire:click="saveSettings">Save Settings</x-button>
            </div>
        </div>
    @else
        {{-- Estado vacío --}}
        <div class="flex-1 flex items-center justify-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <p class="mt-2">Select a conversation or start a new one</p>
                <p class="text-sm text-gray-400 mt-1">Choose from the sidebar or create a new conversation</p>
            </div>
        </div>
    @endif
</div>
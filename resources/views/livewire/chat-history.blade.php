{{-- Sidebar con altura completa dividida en header + scroll independiente --}}
<div class="h-full flex flex-col bg-gray-50 dark:bg-gray-800">
    <!-- Header fijo del historial -->
    <div class="p-4 border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Conversations</h2>
            <button wire:click="newConversation" class="p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" title="New Conversation">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Lista scrolleable independiente con altura calculada -->
    <div class="flex-1 overflow-y-auto" style="height: calc(100vh - 120px);">
        <div class="divide-y dark:divide-gray-700">
            @forelse($conversations as $conv)
            <div class="group relative hover:bg-indigo-50 dark:hover:bg-indigo-900/50 transition-colors border-l-2 border-transparent hover:border-indigo-500">
                <div wire:click="selectConversation({{ $conv->id }})" class="p-4 cursor-pointer">
                    <p class="font-medium truncate text-sm text-gray-800 dark:text-gray-200 pr-8">{{ $conv->title }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $conv->updated_at->diffForHumans() }}</p>
                </div>
                
                <!-- Delete button (shows on hover) -->
                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    @if($confirmingDeletion === $conv->id)
                        <div class="flex items-center space-x-1">
                            <button wire:click="deleteConversation({{ $conv->id }})" class="p-1 text-red-600 hover:bg-red-100 dark:hover:bg-red-900 rounded text-xs" title="Confirm delete">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                            <button wire:click="cancelDelete" class="p-1 text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 rounded text-xs" title="Cancel">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @else
                        <button wire:click="confirmDelete({{ $conv->id }})" class="p-1 text-red-600 hover:bg-red-100 dark:hover:bg-red-900 rounded" title="Delete conversation">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    @endif
                </div>
            </div>
            @empty
             <div class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                No conversations yet.
                <br>
                <span class="text-xs">Click the + button to start</span>
            </div>
            @endforelse
        </div>
    </div>
</div>
<div class="flex flex-col h-full bg-gray-50 dark:bg-gray-800">
    <!-- Cabecera del Historial -->
    <div class="p-4 flex justify-between items-center border-b dark:border-gray-700 shrink-0">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Conversations</h2>
        <button wire:click="newConversation" class="p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" title="New Conversation">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <!-- Lista de Conversaciones con Scroll -->
    <div class="flex-1 overflow-y-auto">
        <ul class="divide-y dark:divide-gray-700">
            @forelse($conversations as $conv)
            <li wire:click="selectConversation({{ $conv->id }})" class="p-4 cursor-pointer hover:bg-indigo-50 dark:hover:bg-indigo-900/50">
                <p class="font-medium truncate text-sm text-gray-800 dark:text-gray-200">{{ $conv->title }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $conv->updated_at->diffForHumans() }}</p>
            </li>
            @empty
             <li class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                No conversations yet.
            </li>
            @endforelse
        </ul>
    </div>
</div>

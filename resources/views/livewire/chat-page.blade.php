{{-- Contenedor principal con altura fija del viewport --}}
<div class="h-screen flex bg-white dark:bg-gray-900">
    <!-- Conversation History Sidebar con altura fija -->
    <div class="w-80 border-r dark:border-gray-700 flex flex-col">
        @livewire('chat-history')
    </div>

    <!-- Active Chat Window con altura fija -->
    <div class="flex-1 flex flex-col">
        @livewire('active-chat')
    </div>
</div>
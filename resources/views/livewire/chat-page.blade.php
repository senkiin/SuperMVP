{{-- Este div toma la altura completa de su padre (definido en dashboard.blade.php) y la divide en dos columnas usando Flexbox. --}}
<div class="flex h-full bg-white dark:bg-gray-900">
    <!-- Conversation History Sidebar -->
    <div class="w-full max-w-xs border-r dark:border-gray-700 shrink-0">
        @livewire('chat-history')
    </div>

    <!-- Active Chat Window -->
    <div class="flex-1">
        @livewire('active-chat')
    </div>
</div>

<x-app-layout>
    <div class="h-screen overflow-hidden">
        @auth
            {{-- Usuario autenticado: chat completo con sidebar --}}
            @livewire('chat-page')
        @else
            {{-- Usuario invitado: solo GuestChat a pantalla completa --}}
            @livewire('guest-chat')
        @endauth
    </div>
</x-app-layout>

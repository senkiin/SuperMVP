{{-- Layout principal del chat con sidebar y chat integrados --}}
<div class="h-screen flex bg-gray-50 dark:bg-gray-900 overflow-hidden">

    {{-- Sidebar de historial de conversaciones --}}
    @livewire('chat-history')

    {{-- Área principal del chat --}}
    @livewire('active-chat')


{{-- Configuración de Alpine.js --}}
<script>
    document.addEventListener('alpine:init', () => {
        // Configuración global si es necesaria
        Alpine.store('chat', {
            sidebarExpanded: Alpine.$persist(true)
        });
    });
</script>

{{-- Estilos globales --}}
<style>
    /* Scrollbar personalizado global */
    .scrollbar-thin::-webkit-scrollbar {
        width: 4px;
    }

    .scrollbar-thumb-gray-300::-webkit-scrollbar-thumb {
        background-color: rgb(209 213 219);
        border-radius: 9999px;
    }

    .scrollbar-thumb-indigo-300::-webkit-scrollbar-thumb {
        background-color: rgb(165 180 252);
        border-radius: 9999px;
    }

    .dark .scrollbar-thumb-gray-700::-webkit-scrollbar-thumb {
        background-color: rgb(55 65 81);
    }

    .dark .scrollbar-thumb-indigo-700::-webkit-scrollbar-thumb {
        background-color: rgb(67 56 202);
    }

    .scrollbar-track-transparent::-webkit-scrollbar-track {
        background: transparent;
    }

    /* Animaciones para elementos interactivos */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    /* Efectos de glassmorphism */
    .glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dark .glass {
        background: rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>

</div>

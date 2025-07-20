<?php

// Actualización del componente app/Livewire/GuestChat.php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Jobs\ProcessGuestMessage;

class GuestChat extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $loading = false;
    public $sessionId;

    protected $listeners = ['echo:guest-chat-{sessionId},guest-message-received' => 'addAiMessage'];

    public function mount()
    {
        // Generate a unique session ID for the guest user
        $this->sessionId = session()->getId();

        // Add welcome message in English and Spanish
        $this->messages[] = [
            'sender' => 'ai',
            'content' => '¡Hola! 👋 Soy tu asistente de IA.

            **Estás en modo invitado**, lo que significa que puedes:
            • Hacer preguntas generales
            • Obtener información básica
            • Probar nuestras funciones principales

            **¿Qué hace nuestra plataforma?**
            Somos una herramienta de IA avanzada que te ayuda con:
            • 📄 **Análisis de documentos personalizados**
            • 💬 **Conversaciones persistentes**
            • 🎯 **Funciones premium**
            • 🔒 **Privacidad garantizada**

            Para desbloquear todo el potencial, puedes [**registrarte gratis aquí**](/register) 🚀

            ¿En qué puedo ayudarte hoy?',
            'timestamp' => now()->toDateTimeString()
        ];
    }

    /**
     * Get listeners with dynamic session ID
     */
    public function getListeners()
    {
        return [
            "echo:guest-chat-{$this->sessionId},guest-message-received" => 'handleAiResponse',
        ];
    }

    /**
     * Sends a message from the guest user.
     */
    // Solo cambiar el método sendMessage() en GuestChat.php
public function sendMessage()
{
    if (empty($this->newMessage)) return;

    $userMessage = $this->newMessage;

    // Agregar mensaje inmediatamente
    $this->messages[] = [
        'sender' => 'user',
        'content' => $userMessage,
        'timestamp' => now()->toDateTimeString()
    ];

    $this->newMessage = '';
    $this->loading = true;
    $this->dispatch('messages-updated');

    // ⚡ ESTO ES LO NUEVO - Procesar de forma asíncrona
    ProcessGuestMessage::dispatch($userMessage, $this->sessionId);
}
    /**
     * Calls the N8N guest workflow and handles the response.
     */
    private function callGuestWorkflow($message)
    {
        try {
            $response = Http::timeout(30)->post(env('N8N_CHAT_GUEST_WEBHOOK_URL'), [
                'query' => $message,
                'session_id' => $this->sessionId,
                'callback_url' => route('api.guest-chat.receive'),
            ]);

            if (!$response->successful()) {
                $this->addErrorMessage();
            }
            // If successful, the response will come via Pusher
        } catch (\Exception $e) {
            $this->addErrorMessage();
        }
    }

    /**
     * Handle AI response from Pusher
     */
    public function handleAiResponse($event)
    {
        $this->addAiMessage($event['content']);
    }

    /**
     * Adds an AI response message to the conversation.
     */
    public function addAiMessage($content)
    {
        $this->messages[] = [
            'sender' => 'ai',
            'content' => $content,
            'timestamp' => now()->toDateTimeString()
        ];
        $this->loading = false;
        $this->dispatch('messages-updated');
    }

    /**
     * Adds an error message when something goes wrong.
     */
    private function addErrorMessage()
    {
        $this->messages[] = [
            'sender' => 'ai',
            'content' => 'Lo siento, ocurrió un error. Por favor intenta de nuevo en unos momentos.

Si este problema persiste, te recomendamos [**crear una cuenta gratuita**](/register) para tener acceso a nuestro soporte técnico y funciones más estables. 🔧',
            'timestamp' => now()->toDateTimeString()
        ];
        $this->loading = false;
        $this->dispatch('messages-updated');
    }

    /**
     * Clears the conversation (for guests).
     */
    public function clearConversation()
    {
        $this->messages = [];
        $this->mount(); // Re-add welcome message
    }

    /**
     * Suggest user registration
     */
    public function suggestRegistration()
    {
        $this->messages[] = [
            'sender' => 'ai',
            'content' => '🎉 **¡Parece que te gusta nuestra plataforma!**

            Con una **cuenta gratuita** podrías:

            • 💾 **Guardar todas tus conversaciones** - Nunca pierdas una charla importante
            • 📄 **Subir y analizar documentos** - PDFs, Word, Excel y más
            • 🎯 **Acceso a funciones premium** - Modelos de IA más avanzados
            • ⚡ **Sin límites de uso** - Chatea todo lo que quieras
            • 🔒 **Privacidad garantizada** - Tus datos completamente seguros
            • 📊 **Dashboard personalizado** - Organiza tus chats y documentos

            [**🚀 Crear cuenta gratuita ahora →**](/register)

            *Solo toma 30 segundos y es completamente gratis.*',
            'timestamp' => now()->toDateTimeString()
        ];
        $this->dispatch('messages-updated');
    }

    public function render()
    {
        return view('livewire.guest-chat');
    }
}

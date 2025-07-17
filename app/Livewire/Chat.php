<?php

namespace App\Livewire;

use App\Events\ChatMessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Chat extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $loading = false;

    /**
     * Define los canales de broadcast que este componente debe escuchar.
     */
    public function getListeners()
    {
        // Escucha en el canal privado del usuario autenticado el evento ChatMessageSent.
        // Cuando llega un mensaje, llama al método 'handleMessageReceived'.
        return [
            "echo-private:chat.".auth()->id().",App\\Events\\ChatMessageSent" => 'handleMessageReceived',
        ];
    }

    /**
     * Se ejecuta cuando el componente se carga por primera vez.
     * Prepara el mensaje de bienvenida.
     */
    public function mount()
    {
        $user = Auth::user();
        // Comprueba si el usuario tiene documentos para decidir el mensaje inicial.
        if ($user->userCompany && $user->userCompany->documents()->count() > 0) {
            $this->messages[] = [
                'sender' => 'ai',
                'content' => '¡Hola de nuevo! He procesado tus documentos. Ya puedes hacerme preguntas sobre tu empresa.',
            ];
        } else {
            $this->messages[] = [
                'sender' => 'ai',
                'content' => '¡Hola! Soy tu asistente de IA. Para poder ayudarte a analizar tu negocio y darte recomendaciones estratégicas, necesito que me proporciones algunos documentos clave sobre tu empresa. ¡Empecemos!',
                'show_button' => true, // Propiedad para mostrar el botón en la vista
            ];
        }
    }

    /**
     * Se llama cuando el usuario envía un mensaje desde el formulario.
     */
    public function sendMessage()
    {
        if (empty($this->newMessage)) {
            return;
        }

        // Añade el mensaje del usuario a la conversación
        $this->messages[] = ['sender' => 'user', 'content' => $this->newMessage];
        $this->loading = true;
        
        // Llama a nuestra propia API, que se encargará de contactar con n8n.
        // Se genera un token de Sanctum de corta duración para autenticar la petición.
        Http::withToken(auth()->user()->createToken('chat-token')->plainTextToken)
            ->post(route('api.chat.send'), ['message' => $this->newMessage]);

        $this->newMessage = '';
    }

    /**
     * Se ejecuta cuando Pusher nos entrega un nuevo mensaje desde el servidor.
     */
    public function handleMessageReceived($event)
    {
        // Añade el mensaje recibido de la IA a la conversación.
        $this->messages[] = $event['message'];
        $this->loading = false; // Oculta el indicador de "escribiendo..."
        $this->dispatch('messages-updated'); // Emite un evento para que Alpine.js haga scroll hacia abajo.
    }

    /**
     * Renderiza la vista del componente.
     */
    public function render()
    {
        return view('livewire.chat');
    }
}

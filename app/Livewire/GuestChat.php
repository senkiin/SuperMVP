<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GuestChat extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $loading = false;
    public $sessionId;
    public $error = null;

    public function mount()
    {
        $this->sessionId = session()->getId();
        $this->addWelcomeMessage();

        // Log session info for debugging
        Log::info('Guest chat mounted', ['session_id' => $this->sessionId]);
    }

    public function sendMessage()
    {
        if (empty($this->newMessage)) return;

        $userMessage = trim($this->newMessage);
        $messageId = Str::uuid()->toString();

        Log::info('🚀 User sending message', [
            'message' => $userMessage,
            'message_id' => $messageId,
            'session_id' => $this->sessionId
        ]);

        // 1. Agregar mensaje del usuario inmediatamente
        $this->messages[] = [
            'id' => $messageId,
            'sender' => 'user',
            'content' => $userMessage,
            'timestamp' => now()->toDateTimeString()
        ];

        // 2. Limpiar input y mostrar loading
        $this->newMessage = '';
        $this->loading = true;
        $this->error = null;

        // 3. Actualizar UI
        $this->dispatch('messages-updated');

        // 4. Enviar a n8n via HTTP (no usar el job queue por ahora)
        $this->sendToN8N($userMessage, $messageId);
    }

   private function sendToN8N($userMessage, $messageId)
{
    $webhookUrl = env('N8N_CHAT_GUEST_WEBHOOK_URL');

    if (!$webhookUrl) {
        Log::error('N8N webhook URL not configured');
        $this->addErrorMessage('Chat service not configured. Please check your .env file.');
        return;
    }

    Log::info('=== SENDING TO N8N ===', [
        'url' => $webhookUrl,
        'message' => $userMessage,
        'session_id' => $this->sessionId,
        'message_id' => $messageId
    ]);

    // SIEMPRE iniciar polling
    $this->dispatch('start-polling', messageId: $messageId);

    // Enviar en background usando dispatch
    dispatch(function () use ($webhookUrl, $userMessage, $messageId) {
        try {
            Http::timeout(30) // Dar más tiempo a n8n
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])
                ->post($webhookUrl, [
                    'query' => $userMessage,
                    'session_id' => $this->sessionId,
                    'message_id' => $messageId,
                    'callback_url' => route('api.guest-chat.receive'),
                    'timestamp' => now()->toDateTimeString()
                ]);

            Log::info('N8N webhook completed');
        } catch (\Exception $e) {
            Log::warning('N8N webhook error (but response may still arrive via callback)', [
                'error' => $e->getMessage()
            ]);
        }
    })->afterResponse(); // Ejecutar después de enviar respuesta al usuario
}

    public function checkForResponse($messageId = null)
    {
        Log::info('Checking for response', [
            'session_id' => $this->sessionId,
            'message_id' => $messageId
        ]);

        // Buscar en múltiples claves de cache
        $cacheKeys = [];

        if ($messageId) {
            $cacheKeys[] = "ai_response_{$this->sessionId}_{$messageId}";
        }
        $cacheKeys[] = "ai_response_{$this->sessionId}";
        $cacheKeys[] = "full_response_{$this->sessionId}";

        foreach ($cacheKeys as $cacheKey) {
            $response = Cache::get($cacheKey);

            if ($response) {
                Log::info('✅ Found response in cache', [
                    'cache_key' => $cacheKey,
                    'content_preview' => substr(is_string($response) ? $response : json_encode($response), 0, 100)
                ]);

                // Limpiar cache
                Cache::forget($cacheKey);

                // Procesar respuesta
                $content = $response;

                // Si es un array con 'content', extraerlo
                if (is_array($content) && isset($content['content'])) {
                    $content = $content['content'];
                }

                // Si es JSON string, decodificar
                if (is_string($content) && str_starts_with($content, '{')) {
                    try {
                        $decoded = json_decode($content, true);
                        if (isset($decoded['content'])) {
                            $content = $decoded['content'];
                        }
                    } catch (\Exception $e) {
                        // Si falla el decode, usar el string tal cual
                    }
                }

                // Agregar mensaje de IA
                $this->messages[] = [
                    'id' => Str::uuid()->toString(),
                    'sender' => 'ai',
                    'content' => $content,
                    'timestamp' => now()->toDateTimeString()
                ];

                $this->loading = false;
                $this->dispatch('messages-updated');
                $this->dispatch('stop-polling', messageId: $messageId);

                return true;
            }
        }

        Log::info('No response found in cache');
        return false;
    }

    // Método alternativo usando HTTP polling directo
    public function pollForResponse($messageId = null)
    {
        try {
            $url = route('api.guest-chat.poll', [
                'sessionId' => $this->sessionId,
                'messageId' => $messageId
            ]);

            $response = Http::get($url);

            if ($response->successful() && $response->json('success')) {
                $content = $response->json('content');

                $this->messages[] = [
                    'id' => Str::uuid()->toString(),
                    'sender' => 'ai',
                    'content' => $content,
                    'timestamp' => now()->toDateTimeString()
                ];

                $this->loading = false;
                $this->dispatch('messages-updated');
                $this->dispatch('stop-polling', messageId: $messageId);

                return true;
            }
        } catch (\Exception $e) {
            Log::error('Polling error', ['error' => $e->getMessage()]);
        }

        return false;
    }

    private function addWelcomeMessage()
    {
        $this->messages[] = [
            'id' => 'welcome-' . time(),
            'sender' => 'ai',
            'content' => '¡Hola! 👋 Soy tu asistente de IA.

**Estás en modo invitado**, lo que significa que puedes:
- Hacer preguntas generales
- Obtener información básica
- Probar nuestras funciones principales

**¿Qué hace nuestra plataforma?**
Somos una herramienta de IA avanzada que te ayuda con:
- 📄 **Análisis de documentos personalizados**
- 💬 **Conversaciones persistentes**
- 🎯 **Funciones premium**
- 🔒 **Privacidad garantizada**

Para desbloquear todo el potencial, puedes [**registrarte gratis aquí**](/register) 🚀

¿En qué puedo ayudarte hoy?',
            'timestamp' => now()->toDateTimeString()
        ];
    }

    private function addErrorMessage($errorText = null)
    {
        $defaultError = 'Lo siento, ocurrió un error. Por favor intenta de nuevo en unos momentos.

Si este problema persiste, te recomendamos [**crear una cuenta gratuita**](/register) para tener acceso a nuestro soporte técnico y funciones más estables. 🔧';

        $this->messages[] = [
            'id' => 'error-' . time(),
            'sender' => 'ai',
            'content' => $errorText ?? $defaultError,
            'timestamp' => now()->toDateTimeString()
        ];

        $this->loading = false;
        $this->dispatch('messages-updated');
    }

    public function clearConversation()
    {
        $this->messages = [];
        $this->loading = false;
        $this->error = null;
        $this->addWelcomeMessage();
        $this->dispatch('messages-updated');
    }

    // Método para testing
    public function testConnection()
    {
        try {
            $testUrl = url('/api/guest-chat/test');
            $response = Http::get($testUrl);

            if ($response->successful()) {
                $this->error = null;
                Log::info('Connection test successful', $response->json());
                return true;
            } else {
                $this->error = 'Connection test failed';
                return false;
            }
        } catch (\Exception $e) {
            $this->error = 'Connection test error: ' . $e->getMessage();
            return false;
        }
    }

    public function render()
    {
        return view('livewire.guest-chat');
    }
}

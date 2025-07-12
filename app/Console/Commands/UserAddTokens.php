<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UserAddTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add-tokens {email} {amount}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds (refunds) a specified amount of processing tokens to a user\'s account by decreasing their usage count.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $amount = (int) $this->argument('amount');

        // Validar que la cantidad sea un número positivo.
        if ($amount <= 0) {
            $this->error('The amount of tokens must be a positive number.');
            return 1;
        }

        // Buscar al usuario por su email.
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }

        $currentUsage = $user->tokens_used;

        // Asegurarse de que el uso no sea negativo.
        $newUsage = max(0, $currentUsage - $amount);
        $refundedAmount = $currentUsage - $newUsage;

        // Usar decrement para una operación atómica en la base de datos.
        $user->decrement('tokens_used', $refundedAmount);

        $this->info("Success! Tokens for user {$user->name} ({$email}) have been updated.");
        $this->line("Tokens refunded: <fg=yellow>{$refundedAmount}</>");
        $this->line("Previous token usage: <fg=yellow>{$currentUsage}</>");
        $this->line("New token usage: <fg=yellow>{$newUsage}</>");

        return 0;
    }
}

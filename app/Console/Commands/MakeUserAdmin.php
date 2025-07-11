<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    /**
     * La firma del comando. Le decimos que acepte un email como argumento.
     * @var string
     */
    protected $signature = 'user:admin {email}';

    /**
     * La descripción del comando.
     * @var string
     */
    protected $description = 'Hace que un usuario existente sea administrador';

    /**
     * Ejecuta la lógica del comando.
     */
    public function handle()
    {
        // Obtenemos el email que el usuario escribió en la terminal
        $email = $this->argument('email');

        // Buscamos al usuario en la base de datos
        $user = User::where('email', $email)->first();

        // Si no encontramos al usuario, mostramos un error y salimos
        if (!$user) {
            $this->error("No se encontró ningún usuario con el email: {$email}");
            return 1; // Devuelve 1 para indicar un error
        }

        // Cambiamos el valor de is_admin a true
        $user->is_admin = true;
        $user->save();

        // Mostramos un mensaje de éxito
        $this->info("¡Éxito! El usuario {$user->name} ({$email}) ahora es un administrador.");

        return 0; // Devuelve 0 para indicar que todo fue bien
    }
}
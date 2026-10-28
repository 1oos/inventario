<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class PromoteUserToSuperadmin extends Command
{
    protected $signature = 'inventario:promote-superadmin {email : Correo de la cuenta que será superadmin}';

    protected $description = 'Asigna el rol de superadmin o crea la primera cuenta';

    public function handle(): int
    {
        $email = $this->argument('email');
        Validator::make(['email' => $email], ['email' => ['required', 'email', 'max:255']])->validate();

        $user = User::query()->where('email', $email)->first();

        if ($user) {
            $user->update(['role' => 'superadmin']);
            $this->info("La cuenta {$user->email} ahora es superadmin.");

            return self::SUCCESS;
        }

        $name = $this->ask('Nombre del superadmin');
        $password = $this->secret('Contraseña (mínimo 8 caracteres)');
        $confirmation = $this->secret('Confirma la contraseña');

        if (! is_string($name) || trim($name) === '' || ! is_string($password) || strlen($password) < 8 || $password !== $confirmation) {
            $this->error('No se creó la cuenta. Revisa el nombre, la longitud de la contraseña y su confirmación.');

            return self::FAILURE;
        }

        User::create([
            'name' => trim($name),
            'email' => $email,
            'password' => $password,
            'role' => 'superadmin',
        ]);

        $this->info("Se creó la cuenta superadmin {$email}.");

        return self::SUCCESS;
    }
}

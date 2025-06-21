<?php

declare(strict_types=1);

namespace App\Traits;

trait ChangePasswordUserTrait
{
    public $password;

    public $password_confirmation;

    public function changePassword()
    {
        $this->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $this->user->update([
            'password' => bcrypt($this->password),
        ]);

        $this->alert('La clave del usuario ha sido actualizada correctamente', 'success', 'Cambio de Clave');
    }

    public function generatePassword()
    {
        $this->password = bin2hex(random_bytes(4)); // Generates a random 8-character password
        $this->password_confirmation = $this->password;

        $this->alert('La clave del usuario ha sido generada correctamente.', 'info', 'Generación de Clave');
    }
}

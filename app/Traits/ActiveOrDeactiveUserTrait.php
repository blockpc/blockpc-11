<?php

declare(strict_types=1);

namespace App\Traits;

trait ActiveOrDeactiveUserTrait
{
    public $is_active = true;

    public function bootActiveOrDeactiveUserTrait()
    {
        $this->is_active = $this->user->is_active;
    }

    public function updatedIsActive($value)
    {
        $this->user->is_active = $value;
        $this->user->save();

        if ($this->is_active) {
            $this->alert('Usuario activado correctamente', 'success', 'Activar Usuario');
        } else {
            $this->alert('Usuario desactivado correctamente', 'warning', 'Desactivar Usuario');
        }
    }
}

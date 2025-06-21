<?php

declare(strict_types=1);

namespace App\Traits;

trait ActiveOrDeactiveUserTrait
{
    public $active = true;

    public function bootActiveOrDeactiveUserTrait()
    {
        $this->active = $this->user->active;
    }

    public function toggleActive()
    {
        $this->active = ! $this->active;
        $this->user->active = $this->active;
        $this->user->save();

        if ($this->active) {
            $this->alert('Usuario activado correctamente', 'success', 'Activar Usuario');
        } else {
            $this->alert('Usuario desactivado correctamente', 'warning', 'Desactivar Usuario');
        }
    }
}

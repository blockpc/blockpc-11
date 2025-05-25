<?php

declare(strict_types=1);

namespace Blockpc\App\Traits;

use Blockpc\App\Livewire\MessageAlerts;

trait AlertBrowserEvent
{
    public function alert(string $message, string $type = 'success', string $title = '', int $time = 5000)
    {
        $this->dispatch('show', $message, $type, $title, $time)->to(MessageAlerts::class);
    }

    public function flash(string $message, string $type = 'success')
    {
        session()->flash($type, $message);
    }
}

<?php

declare(strict_types=1);

namespace Blockpc\App\Traits;

trait AlertBrowserEvent
{
    // public function alert(string $message, string $type = 'success', string $title = '', int $time = 5000)
    // {
    //     $this->dispatch('show', $message, $type, $title, $time)->to(Toast::class);
    // }

    // public function toaster(string $message, string $type = 'success')
    // {
    //     Toaster::$type($message);
    // }

    public function flash(string $message, string $type = 'success')
    {
        session()->flash($type, $message);
    }
}

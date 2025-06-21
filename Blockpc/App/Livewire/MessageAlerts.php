<?php

declare(strict_types=1);

namespace Blockpc\App\Livewire;

use Livewire\Component;

/**
 * message-alerts
 */
final class MessageAlerts extends Component
{
    public $open = false;

    public $message = '';

    public $class_alert = '';

    public $title = '';

    public $time = 5000;

    protected $listeners = [
        'show',
    ];

    public function mount()
    {
        $this->hide();
    }

    public function render()
    {
        return view('blockpc::livewire.message-alerts');
    }

    public function show(string $message, string $alert, string $title, int $time = 5000)
    {
        $this->open = true;
        $this->message = $message;
        $this->class_alert = $this->match_type($alert);
        $this->title = $title;
        $this->time = $time;
    }

    public function hide()
    {
        $this->reset();
    }

    private function match_type($alert)
    {
        return match ($alert) {
            'success' => 'alert alert-success',
            'error' => 'alert alert-danger',
            'warning' => 'alert alert-warning',
            'info' => 'alert alert-info',
            default => 'alert alert-info',
        };
    }
}

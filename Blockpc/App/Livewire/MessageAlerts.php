<?php

declare(strict_types=1);

namespace Blockpc\App\Livewire;

use Blockpc\App\Traits\AlertBrowserEvent;
use Livewire\Component;

/**
 * message-alerts
 */
final class MessageAlerts extends Component
{
    use AlertBrowserEvent;

    protected $listeners = [
        'show'
    ];

    public $open = false;

    public $message = '';

    public $type = '';

    public $title = '';

    public $time = 5000;

    public function mount()
    {
        $this->hide();
    }

    public function render()
    {
        return view('blockpc::livewire.message-alerts');
    }

    public function show(string $message, string $type, string $title, int $time = 5000)
    {
        $this->open = true;
        $this->message = $message;
        $this->type = $this->match_type($type);
        $this->title = $title;
        $this->time = $time;
    }

    public function hide()
    {
        $this->reset();
    }

    private function match_type($type)
    {
        return match($type) {
            'success' => 'alert alert-success',
            'error' => 'alert alert-danger',
            'warning' => 'alert alert-warning',
            'info' => 'alert alert-info',
            default => 'alert alert-info',
        };
    }

}

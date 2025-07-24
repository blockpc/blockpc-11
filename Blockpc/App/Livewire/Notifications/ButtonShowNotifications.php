<?php

declare(strict_types=1);

namespace Blockpc\App\Livewire\Notifications;

use Blockpc\App\Traits\AlertBrowserEvent;
use Livewire\Component;

final class ButtonShowNotifications extends Component
{
    use AlertBrowserEvent;

    public $open = false;

    public $user_id;

    public function getListeners()
    {
        $listeners = [
            'refresh' => '$refresh',
            'close_sidebar',
        ];

        // If the Reverb feature is enabled, listen for private user events
        if ( config('app.blockpc.reverb.enabled')) {
            $listeners[] = "echo:private-users.{$this->user_id},.SendMessagePusherEvent";
        }

        return $listeners;
    }

    public function mount()
    {
        $this->user_id = current_user()->id;
    }

    public function render()
    {
        return view('blockpc::livewire.notifications.button', [
            'unreadNotifications' => current_user()->unreadNotifications,
        ]);
    }

    public function recibido()
    {
        $this->alert('Ha llegado un mensaje.', title:'Notificación');
    }

    public function open_close()
    {
        $this->open = ! $this->open;

        if ($this->open) {
            $this->dispatch('show_sidebar')->to(SidebarNotification::class);
        }
    }

    public function close_sidebar()
    {
        $this->open = false;
        $this->dispatch('refresh')->self();
    }
}

<?php

declare(strict_types=1);

namespace Blockpc\App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;

final class UserNotification extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public string $message, public string $type, public User $from)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'type' => $this->type,
            'from_id' => $this->from->id,
        ];
    }
}

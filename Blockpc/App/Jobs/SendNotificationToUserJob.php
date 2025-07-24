<?php

declare(strict_types=1);

namespace Blockpc\App\Jobs;

use App\Models\User;
use Blockpc\App\Events\SendMessagePusherEvent;
use Blockpc\App\Notifications\UserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

final class SendNotificationToUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public string $message, public string $type_id, public int $user_id, public int $current_user_id)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->user_id);
        $current_user = User::find($this->current_user_id);

        Notification::send($user, new UserNotification($this->message, $this->type_id, $current_user));

        if (config('app.blockpc.reverb.enabled')) {
            event(new SendMessagePusherEvent($user->id));
        }
    }
}

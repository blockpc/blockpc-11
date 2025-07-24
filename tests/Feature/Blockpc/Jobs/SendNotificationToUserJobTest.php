<?php

declare(strict_types=1);

use Blockpc\App\Events\SendMessagePusherEvent;
use Blockpc\App\Jobs\SendNotificationToUserJob;
use Blockpc\App\Notifications\UserNotification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

uses()->group('jobs');

beforeEach(function () {
    $this->user = new_user();
    $this->admin = new_user(role: 'admin');
});

test('notification is sent to the user but no broadcasting', function () {
    $this->actingAs($this->user);

    Notification::fake();
    Event::fake();

    $message = 'Test message';
    $type_id = 'info';

    $job = new SendNotificationToUserJob($message, $type_id, $this->admin->id, $this->user->id);
    $job->handle();

    Notification::assertSentTo(
        [$this->admin], UserNotification::class, function ($notification, $channels) use ($message, $type_id) {
            return $notification->message === $message &&
                   $notification->type === $type_id &&
                   $notification->from->id === $this->user->id;
        }
    );

    Event::assertNotDispatched(SendMessagePusherEvent::class);
});

test('notification is sent to the user and broadcasting', function () {
    $this->actingAs($this->user);

    Notification::fake();
    Event::fake();
    Config::set('app.blockpc.reverb.enabled', true);

    $message = 'Test message';
    $type_id = 'info';

    $job = new SendNotificationToUserJob($message, $type_id, $this->admin->id, $this->user->id);
    $job->handle();

    Notification::assertSentTo(
        [$this->admin], UserNotification::class, function ($notification, $channels) use ($message, $type_id) {
            return $notification->message === $message &&
                   $notification->type === $type_id &&
                   $notification->from->id === $this->user->id;
        }
    );

    Event::assertDispatched(SendMessagePusherEvent::class);
});

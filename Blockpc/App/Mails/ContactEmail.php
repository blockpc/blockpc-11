<?php

declare(strict_types=1);

namespace Blockpc\App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $address;

    public $me;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public $data)
    {
        $this->address = env('MAIL_FROM_ADDRESS', 'soporte@mail.com');
        $this->me = env('MAIL_CONTACT', 'soporte@mail.com');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->address)
            ->to($this->me)
            ->subject('Nuevo Mensaje de contacto | '.config('app.name'))
            ->markdown('emails.contact');
    }
}

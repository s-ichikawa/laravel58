<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class ApiSandBoxMail extends Mailable
{
    use Queueable, SerializesModels, SendGrid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('mails.simple')
            ->to(env('AUTHOR_EMAIL'))
            ->subject('api sample mailable')
            ->sendgrid([
                'categories'    => [
                    'api_sandbox_mailable',
                ],
                'mail_settings' => [
                    'sandbox_mode' => [
                        'enable' => true,
                    ],
                ],
            ]);
    }
}

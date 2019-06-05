<?php

namespace App\Console\Commands\Mail;

use Illuminate\Console\Command;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Sichikawa\LaravelSendgridDriver\SendGrid;
use Sichikawa\LaravelSendgridDriver\Transport\SendgridTransport;
use Swift_Events_SendEvent;

class ApiSimple extends Command
{
    use SendGrid;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendgrid:mail-api-simple';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var Mailer $mailer */
        $mailer = app('mailer');
        $mailer->getSwiftMailer()->registerPlugin(new MailTracker());
        $mailer->send([], [], function (Message $message) {
            $message
                ->subject('[Sample] simple mail.')
                ->to('ichikawa.shingo.0829+reply@gmail.com')
                ->from("ichikawa.shingo.0829@gmail.com", "Shingo Ichikawa")
                ->replyTo('ichikawa.shingo.0829+reply@gmail.com')
                ->embedData(self::sgEncode([
                    'personalizations' => [
                        [
                            'to' => [
                                'email' => 'ichikawa.shingo.0829@gmail.com',
                                'name'  => 's-ichikawa1',
                            ],
                            'dynamic_template_data' => [
                                'name' => 'Shingo Ichikawa',
                            ],
                        ],
                    ],
                    'template_id' => config('services.sendgrid.templates.dynamic_sample')
                ]), SendgridTransport::SMTP_API_NAME);
        });
    }
}

class MailTracker implements \Swift_Events_SendListener
{
    /**
     * Invoked immediately before the Message is sent.
     *
     * @param Swift_Events_SendEvent $evt
     */
    public function beforeSendPerformed(Swift_Events_SendEvent $evt)
    {
    }
    /**
     * Invoked immediately after the Message is sent.
     *
     * @param Swift_Events_SendEvent $evt
     */
    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
        \Log::info('X-Message-ID:' . $evt->getMessage()->getHeaders()->get('X-Message-Id')->getFieldBody());
    }
}
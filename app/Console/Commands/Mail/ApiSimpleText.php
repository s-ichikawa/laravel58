<?php

namespace App\Console\Commands\Mail;

use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Sichikawa\LaravelSendgridDriver\SendGrid;
use Sichikawa\LaravelSendgridDriver\Transport\SendgridTransport;

class ApiSimpleText extends Command
{
    use SendGrid;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendgrid:mail-api-simple-text';

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
        app('mailer')->send(['text' => 'mails.simple_text'], [], function (Message $message) {
            $message
                ->subject('[Sample] simple text mail.')
                ->to('dumy@example.com')
                ->replyTo('ichikawa.shingo.0829+reply@gmail.com')
                ->embedData(self::sgEncode([
                    'personalizations' => [
                        [
                            'to' => [
                                'email' => 'ichikawa.shingo.0829+test1@gmail.com',
                                'name'  => 's-ichikawa1',
                            ],
                        ],
                    ],
                    'categories' => ['Order']
                ]), SendgridTransport::SMTP_API_NAME);
        });
    }
}

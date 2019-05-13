<?php

namespace App\Console\Commands\Mail;

use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Sichikawa\LaravelSendgridDriver\Transport\SendgridTransport;

class ApiMultiplePersonalizations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendgrid:mail-api-multiple-personalizations';

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
        \Mail::send('mails.simple', [], function (Message $message) {
            $message
                ->subject('[Sample] multiple mail.')
                ->to('dumy@example.com')
                ->embedData([
                    'personalizations' => [
                        [
                            'to'         => [
                                'email' => 'ichikawa.shingo.0829+test1@gmail.com',
                                'name'  => 's-ichikawa1',
                            ],
                            'categories' => ['category_a_1', 'category_b_1'],
                        ],
                        [
                            'to'         => [
                                'email' => 'ichikawa.shingo.0829+test2@gmail.com',
                                'name'  => 's-ichikawa2',
                            ],
                            'categories' => ['category_a_2', 'category_b_2'],
                        ],
                    ],

                ], SendgridTransport::SMTP_API_NAME);
        });
    }
}

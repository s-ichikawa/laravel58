<?php

namespace App\Console\Commands\Mail;

use Illuminate\Console\Command;
use React\EventLoop\Factory;
use React\HttpClient\Client;
use React\HttpClient\Response;

class ReactSender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendgrid:react-sender';

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
        $loop = Factory::create();
        $connector = new \React\Socket\Connector($loop, array(
            'dns' => '8.8.8.8',
        ));
        $client = new Client($loop, $connector);



        $payload = json_encode([
            'personalizations' => [
                [
                    'to' => [
                        [
                            'email' => 'ichikawa.shingo.0829+test1@gmail.com',
                            'name' => 's-ichikawa1',
                        ]
                    ],
                    'subject' => 'send from react php'
                ],
            ],
            'from' => [
                'email' => 'dumy@example.com'
            ],
            'content' => [
                [
                    'type' => 'text/plain',
                    'value' => 'Hello World',
                ]
            ]
        ]);

        $request = $client->request('POST', 'https://api.sendgrid.com/v3/mail/send', [
            'Authorization' => 'Bearer ' . config('services.sendgrid.api_key'),
            'Content-Type' => 'application/json',
            'Content-Length' => strlen($payload),
        ], '1.1');

        $request->on('response', function (Response $response) {
            $response->on('data', function ($chunk) {
                echo $chunk;
            });
        });

        $request->end($payload);
        $loop->run();
    }
}

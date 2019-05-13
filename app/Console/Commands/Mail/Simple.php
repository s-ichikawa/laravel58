<?php

namespace App\Console\Commands\Mail;

use Illuminate\Console\Command;
use Illuminate\Mail\Message;

class Simple extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendgrid:mail-simple';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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
                ->subject('[Sample] simple mail.')
                ->to(env('AUTHOR_EMAIL'))
                ->replyTo('ichikawa.shingo.0829@gmail.com', 's-ichika');
        });
    }
}

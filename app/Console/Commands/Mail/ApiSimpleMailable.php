<?php

namespace App\Console\Commands\Mail;

use Illuminate\Console\Command;

class ApiSimpleMailable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendgrid:mail-api-simple-mailable';

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
        \Mail::to(env('AUTHOR_EMAIL'), 'tester')
            ->cc("ichikawa.shingo.0829+cc@gmail.com")
            ->bcc("ichikawa.shingo.0829+bcc@gmail.com")
            ->send(new \App\Mail\ApiSimpleMailable());
    }
}

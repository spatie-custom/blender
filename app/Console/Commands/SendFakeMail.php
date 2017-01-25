<?php

namespace App\Console\Commands;

use Mail;
use Illuminate\Console\Command;
use App\Services\MailableFactory;

class SendFakeMail extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'mail:fake {mailableClass}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear a Beanstalkd queue, by deleting all pending jobs.';

    /**
     * Defines the arguments.
     *
     * @return array
     */
    public function handle()
    {
        $mailable = MailableFactory::create($this->argument('mailableClass'));

        Mail::to('freek@spatie.be')->send($mailable);

        $this->comment('Mail sent!');
    }
}

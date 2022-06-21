<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UsergroupCandidate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The tour object instance.
     *
     * @var Tour
     */
    public $group;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Object $group)
    {
        $this->group = $group;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email='noreply@simplytourit.com';
        if(env('MAIL_FROM_ADDRESS'))
            $email=env('MAIL_FROM_ADDRESS');
        return $this->from($email)
            ->subject(__('New group applicant'))
            ->view('mails.usergroups.candidate')
            ->text('mails.usergroups.candidate_plain');
    }
}

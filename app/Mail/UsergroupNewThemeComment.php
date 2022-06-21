<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UsergroupNewThemeComment extends Mailable
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
            ->subject(__('A new comment in the group topic has been added!'))
            ->view('mails.usergroups.new_theme_comment')
            ->text('mails.usergroups.new_theme_comment_plain');
    }
}

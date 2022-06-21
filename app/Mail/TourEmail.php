<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TourEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The tour object instance.
     *
     * @var Tour
     */
    public $tour;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Object $tour)
    {
        $this->tour = $tour;
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
            ->subject(__('There have been changes to the tour you are a member of!'))
            ->view('mails.tour.status')
            ->text('mails.tour.status_plain');
    }
}

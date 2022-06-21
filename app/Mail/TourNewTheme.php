<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TourNewTheme extends Mailable
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
            ->subject(__('A new discussion in the tour has been added!'))
            ->view('mails.tour.new_theme')
            ->text('mails.tour.new_theme_plain');
    }
}

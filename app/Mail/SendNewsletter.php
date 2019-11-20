<?php

namespace App\Mail;

use App\Newsletter;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewsletter extends Mailable
{
    use Queueable, SerializesModels;
    public $newsletter;
    public $user;

    /**
     * Newsletters constructor.
     * @param Newsletter $newsletter
     * @param User $user
     */
    public function __construct(Newsletter $newsletter, User $user)
    {
        $this->newsletter = $newsletter;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newsletter.sending')
            ->text('emails.newsletter.sending_plain')
            ->subject($this->newsletter->title);
    }
}

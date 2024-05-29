<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SimpleMessage extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $body;

    /**
     * Create a new message instance.
     */
    public function __construct(string $subject, string $body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }


     /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(
            'layouts.simple_mail',
            [
                'subject' => $this->subject,
                'body' => $this->body
            ]
        )->subject($this->subject);
    }
}

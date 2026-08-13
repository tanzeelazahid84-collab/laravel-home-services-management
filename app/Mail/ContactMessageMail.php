<?php

namespace App\Mail;

use App\Models\ContactQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactQuery;

    public function __construct(ContactQuery $contactQuery)
    {
        $this->contactQuery = $contactQuery;
    }

    public function build()
{
    return $this->subject('New Contact Message: ' . $this->contactQuery->subject)
        ->replyTo($this->contactQuery->email, $this->contactQuery->name)
        ->view('emails.contact-message');
}
}
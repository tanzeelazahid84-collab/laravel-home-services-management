<?php

namespace App\Mail;

use App\Models\ContactQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactQuery;
    public $replySubject;
    public $replyMessage;
    public $adminName;

    public function __construct(ContactQuery $contactQuery, string $replySubject, string $replyMessage)
    {
        $this->contactQuery = $contactQuery;
        $this->replySubject = $replySubject;
        $this->replyMessage = $replyMessage;
        $this->adminName = auth()->check() ? auth()->user()->name : config('app.name');
    }

    public function build()
    {
        return $this->subject($this->replySubject)
            ->to($this->contactQuery->email, $this->contactQuery->name)
            ->view('emails.contact-reply')
            ->with([
                'contactQuery' => $this->contactQuery,
                'replyMessage' => $this->replyMessage,
                'adminName' => $this->adminName,
            ]);
    }
}

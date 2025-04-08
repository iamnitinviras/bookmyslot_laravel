<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketReplyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $url;
    public $email;
    public $ticket_subject;
    public $email_text;
    public $ticket_comment;
    public function __construct($name,$email_text,$email,$ticket_subject,$url,$ticket_comment)
    {
        $this->name = $name;
        $this->email = $email;
        $this->email_text = $email_text;
        $this->url = $url;
        $this->ticket_subject = $ticket_subject;
        $this->ticket_comment = $ticket_comment;
    }

    public function build()
    {
        $subject=trans('system.tickets.new_reply_received')." - ".$this->ticket_subject;
        return $this->view('emails.ticket_reply')
            ->subject($subject)
            ->to($this->email)
            ->with([
                'name' => $this->name,
                'email_text' => $this->email_text,
                'ticket_subject' => $this->ticket_subject,
                'url' => $this->url,
                'ticket_comment' => $this->ticket_comment,
            ]);
    }
}

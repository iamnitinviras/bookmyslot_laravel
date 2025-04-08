<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketAssignMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $url;
    public $email;
    public $ticket_subject;
    public $ticket_comment;
    public function __construct($name,$email,$ticket_subject,$url,$ticket_comment)
    {
        $this->name = $name;
        $this->email = $email;
        $this->url = $url;
        $this->ticket_subject = $ticket_subject;
        $this->ticket_comment = $ticket_comment;
    }

    public function build()
    {
        $subject=trans('system.tickets.ticket_assigned_agent')." - ".$this->ticket_subject;
        return $this->view('emails.ticket_assigned_to_agent')
            ->subject($subject)
            ->to($this->email)
            ->with([
                'name' => $this->name,
                'ticket_subject' => $this->ticket_subject,
                'url' => $this->url,
                'ticket_comment' => $this->ticket_comment,
            ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendFeedbackUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $description;
    public $email;
    public $status;
    public $roadmap;
    public $board_name;
    public function __construct($title,$description,$status,$roadmap,$email,$board_name)
    {
        $this->title = $title;
        $this->description = $description;
        $this->status =$status;
        $this->email =$email;
        $this->roadmap =$roadmap;
        $this->board_name =$board_name;
    }

    public function build()
    {
        return $this->view('emails.feedback_update')
            ->subject($this->board_name.": ".trans('system.email_messages.feedback_update'))
            ->to($this->email)
            ->with([
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status,
                'roadmap' => $this->roadmap,
            ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewFeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vendor_name;
    public $title;
    public $description;
    public $email;
    public $board_name;
    public function __construct($vendor_name,$title,$description, $email,$board_name)
    {
        $this->vendor_name = $vendor_name;
        $this->title = $title;
        $this->description = $description;
        $this->email =$email;
        $this->board_name =$board_name;
    }

    public function build()
    {
        return $this->view('emails.feedback')
            ->subject($this->board_name.": ".trans('system.frontend.new_feedback_posted'))
            ->to($this->email)
            ->with([
                'vendor_name' => $this->vendor_name,
                'title' => $this->title,
                'description' => $this->description,
            ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer_name;
    public $url;
    public $email;
    public function __construct($customer_name,$url,$email)
    {
        $this->customer_name = $customer_name;
        $this->url = $url;
        $this->email = $email;
    }

    public function build()
    {
        return $this->view('emails.customer_forget_password')
            ->subject(trans('auth.reset_password.reset_your_password'))
            ->to($this->email)
            ->with([
                'customer_name' => $this->customer_name,
                'url' => $this->url,
            ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer_name;
    public $login_url;
    public $email;
    public $password;
    public function __construct($customer_name,$login_url,$email,$password)
    {
        $this->customer_name = $customer_name;
        $this->login_url = $login_url;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->view('emails.customer_register')
            ->subject(trans('auth.welcome_to').config('app.name'))
            ->to($this->email)
            ->with([
                'customer_name' => $this->customer_name,
                'login_url' => $this->login_url,
                'email' => $this->email,
                'password' => $this->password,
            ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $purpose;

    /**
     * Create a new message instance.
     */
    public function __construct(string $otp, string $purpose = 'xác thực tài khoản')
    {
        $this->otp = $otp;
        $this->purpose = $purpose;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject("Mã OTP cho $this->purpose")
                    ->view('emails.send-otp')
                    ->with([
                        'otp' => $this->otp,
                        'purpose' => $this->purpose,
                    ]);
    }
}

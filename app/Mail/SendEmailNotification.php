<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $voucher;
    public $vouchergenerate;
    public $createdBy;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($voucher, $vouchergenerate, $createdBy)
    {
        $this->voucher = $voucher;
        $this->vouchergenerate = $vouchergenerate;
        $this->createdBy = $createdBy;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $voucher = $this->voucher;
        $vouchergenerate = $this->vouchergenerate;

        $name = env('MAIL_FROM_NAME');
        $emailfrom = env('MAIL_FROM_ADDRESS');
        $subject = $voucher->campaign_message_title;
        $emailSendTo = $vouchergenerate->campaign_recipient_email;
        $emailContent = $voucher->campaign_message_body;

        return $this->view('emails.email')
            ->from($emailfrom, $name)
            ->cc($address, $name)
            ->bcc($address, $name)
            ->replyTo($address, $name)
            ->subject($subject)
            ->with(['message' => $emailContent]);
    }
}

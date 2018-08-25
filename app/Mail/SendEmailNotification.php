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
        $createdBy = $this->createdBy;


        $name = env('MAIL_FROM_NAME');
        $emailfrom = env('MAIL_FROM_ADDRESS');
        $subject = $voucher->campaign_message_title;
        $emailSendTo = $vouchergenerate->campaign_recipient_email;

        $content = $voucher->campaign_message_body;
        $voucherNo = $vouchergenerate->voucher_generated_no;
        $redeemUrl = env('REDEEM_PAGE') . $voucherNo;
        $emailContent = $content . $redeemUrl;

        return $this->view('emails.email')
            ->from($emailfrom, $name)
            ->replyTo($emailfrom, $name)
            ->subject($subject)
            ->with([
                'content' => $content,
                'redeem_url' => $redeemUrl,
            ]);
    }
}

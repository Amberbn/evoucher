<?php

namespace App\Jobs;

use App\Mail\SendEmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $voucher;
    public $vouchergenerate;
    public $createdBy;

    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $voucher = $this->voucher;
        $vouchergenerate = $this->vouchergenerate;
        $createdBy = $this->createdBy;

        \Log::info('send sms email outside voucher for email ' . $voucher->campaign_recipient_email . ' is running on ' . date('Y-m-d H:i:s'));

        $email = new SendEmailNotification($voucher, $vouchergenerate, $createdBy);
        Mail::to($vouchergenerate->campaign_recipient_email)->send($email);
    }
}

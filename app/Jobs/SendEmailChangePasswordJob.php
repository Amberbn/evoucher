<?php

namespace App\Jobs;

use App\Mail\SendEmailChangePassword;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailChangePasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $voucher = $this->user;

        \Log::info('send sms email outside voucher for email ' . $voucher->user_name . ' is running on ' . date('Y-m-d H:i:s'));

        $email = new SendEmailNotification($user);
        Mail::to($user->email)->send($email);
    }
}

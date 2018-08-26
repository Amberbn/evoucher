<?php

namespace App\Listeners;

use App\Events\GenerateVoucherEvent;
use App\Jobs\GenerateVoucherJob;

class SendGenerateVoucherToJob
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GenerateVoucherEvent  $event
     * @return void
     */
    public function handle(GenerateVoucherEvent $vouchers)
    {
        \Log::info('send generate voucher job is running on ' . date('Y-m-d H:i:s'));
        $voucherCollection = $vouchers->vouchers;
        $createdBy = $vouchers->createdBy;
        foreach ($voucherCollection as $voucher) {
            dispatch(new GenerateVoucherJob($voucher, $createdBy));
        }
    }
}

<?php

namespace App\Listeners;

use App\Events\SendSmsEvent;
use App\Jobs\SendVocherSmsJob;

class SendSmsToJob
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
     * @param  SendSmsEvent  $event
     * @return void
     */
    public function handle(SendSmsEvent $vouchers)
    {
        $voucherCollection = $vouchers->vouchers;
        $createdBy = $vouchers->createdBy;
        foreach ($voucherCollection as $voucher) {
            dispatch(new SendVocherSmsJob($voucher, $createdBy));
        }
    }
}

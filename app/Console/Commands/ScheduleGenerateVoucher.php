<?php

namespace App\Console\Commands;

use App\Events\GenerateVoucherEvent;
use DB;
use Illuminate\Console\Command;

class ScheduleGenerateVoucher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ScheduleGenerateVoucher:generateVoucher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Generate Voucher';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $vouchers = DB::table('vw_voucher_generated_global')->get();
        if ($vouchers) {
            $createdBy = "Laravel Job";
            \Log::info('Schedule Generate Voucher is running on ' . date('Y-m-d H:i:s'));
            event(new GenerateVoucherEvent($vouchers, $createdBy));
        }
    }
}

<?php
namespace App\Repository;

use App\Events\SendSmsEvent;
use App\Repository\BaseRepository;
use App\VoucherGenerated;
use DB;

class VoucherGeneratedRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new VoucherGenerated;
    }

    public function getVoucherGenerated($campaignId)
    {
        try {
            DB::beginTransaction();

            $vouchers = DB::table('vw_voucher_generated_global as generated')
                ->where('generated.campaign_id', $campaignId)->get();

            if (!$vouchers) {
                return $this->sendNotfound();
            }

            $createdBy = $this->loginUsername();
            event(new SendSmsEvent($vouchers, $createdBy));
            DB::commit();
            return $this->sendCreated();

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }

    }

}

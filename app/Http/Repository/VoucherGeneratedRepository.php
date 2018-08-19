<?php
namespace App\Repository;

use DB;
use App\Campaign;
use App\VoucherGenerated;
use App\Events\SendSmsEvent;
use App\Repository\BaseRepository;

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

            $campaign = Campaign::where('campaign_id', $campaignId)->first();
            if (!$campaign) {
                return $this->sendNotfound();
            }
            $campaign->campaign_status = 'RELEASED';
            $campaign->save();

            $vouchers = DB::table('vw_voucher_generated_global_by_event as generated')
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

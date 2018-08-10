<?php
namespace App\Repository;

use App\Jobs\SendVocherSmsJob;
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

            $vouchers = DB::table('vw_voucher_generated as generated')
                ->join('bsn_campaign as campaign', 'campaign.campaign_id', 'generated.campaign_id')
                ->join('bsn_campaign_vouchers as voucher', 'voucher.campaign_voucher_id', 'generated.campaign_voucher_id')
                ->join('vou_voucher_catalog as catalog', 'catalog.voucher_catalog_id', 'voucher.voucher_catalog_id')
                ->where('campaign.campaign_id', $campaignId)
                ->select([
                    'generated.campaign_voucher_id',
                    'generated.campaign_voucher_id',
                    'generated.campaign_id',
                    'generated.client_id',
                    'generated.campaign_recipient_id',
                    'generated.campaign_recipient_salutation',
                    'generated.campaign_recipient_name',
                    'generated.campaign_recipient_phone',
                    'generated.campaign_recipient_email',
                    'generated.voucher_generated_is_redeemed',
                    'generated.voucher_generated_redeem_id',
                    'generated.voucher_generated_locked_till',
                    'generated.voucher_generated_no',
                    'catalog.voucher_catalog_id',
                    'campaign.campaign_distribute_by_sms',
                    'campaign.campaign_distribute_by_email',
                    'campaign.campaign_message_sms',
                    'campaign.campaign_message_body',
                    'campaign.campaign_message_title',
                ])->get();

            if (!$vouchers) {
                return $this->sendNotfound();
            }

            $createdBy = $this->loginUsername();
            dispatch(new SendVocherSmsJob($vouchers, $createdBy));

            DB::commit();
            return $this->sendCreated();

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }

    }

}

<?php

namespace App\Jobs;

use App\Config;
use App\VoucherDistributionTracker;
use App\VoucherGenerated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendVocherSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $voucher;
    protected $createdBy;

    //docker-compose exec app php artisan queue:listen --timeout=60
    //dont forget to add timeout because curl

    public function __construct($voucher, $createdBy)
    {
        $this->voucher = $voucher;
        $this->createdBy = $createdBy;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $smsResponseCodeConfig = Config::where('config_group_name', 'SMS_Respond_Code')
                ->select('config_name', 'config_value')
                ->get();
            $voucherGenerateNo = VoucherGenerated::select('voucher_generated_no')->get()->toArray();
            $randomNumber = rand(9999999999, 1000000000);

            while (in_array($randomNumber, $voucherGenerateNo)) {
                $randomNumber = rand(9999999999, 1000000000);
            }

            $voucher = $this->voucher;
            $vouchergenerate = new VoucherGenerated;
            $vouchergenerate->campaign_voucher_id = $voucher->campaign_voucher_id;
            $vouchergenerate->voucher_generated_no = $randomNumber;
            $vouchergenerate->campaign_id = $voucher->campaign_id;
            $vouchergenerate->client_id = $voucher->client_id;
            $vouchergenerate->campaign_recipient_id = $voucher->campaign_recipient_id;
            $vouchergenerate->campaign_recipient_salutation = $voucher->campaign_recipient_salutation;
            $vouchergenerate->campaign_recipient_name = $voucher->campaign_recipient_name;
            $vouchergenerate->campaign_recipient_phone = $voucher->campaign_recipient_phone;
            $vouchergenerate->campaign_recipient_email = $voucher->campaign_recipient_email;
            $vouchergenerate->voucher_generated_is_redeemed = $voucher->voucher_generated_is_redeemed;
            $vouchergenerate->voucher_generated_redeem_id = $voucher->voucher_generated_redeem_id;
            $vouchergenerate->voucher_generated_locked_till = $voucher->voucher_generated_locked_till;
            $vouchergenerate->save();

            $isDistributeBySms = (int) $voucher->campaign_distribute_by_sms == 1 ? true : false;
            $handphone = $vouchergenerate->campaign_recipient_phone;
            $email = $vouchergenerate->campaign_recipient_phone;

            if ($handphone && $isDistributeBySms) {
                $type = 'SMS';
                $referenceId = null;
                $responseCode = null;
                $responseCallback = $this->sendSMS($voucher);

                if ($responseCallback) {
                    $responseCode = explode('-', $responseCallback);
                    $referenceId = $responseCode[1];
                }

                $responseMessage = $smsResponseCodeConfig->where('config_value', $responseCode[0])
                    ->first()->config_name;

                $distribution = new VoucherDistributionTracker;
                $distribution->voucher_generated_id = $vouchergenerate->voucher_generated_id;
                $distribution->voucher_id = $voucher->voucher_catalog_id;
                $distribution->voucher_generated_no = $vouchergenerate->voucher_generated_no;
                $distribution->voucher_distribution_type = $type;
                $distribution->voucher_distribution_reference_id = $referenceId;
                $distribution->voucher_distribution_respond_code = $responseCallback;
                $distribution->voucher_distribution_respond_message = $responseMessage;
                $distribution->voucher_distribution_execution_timestamp = NOW();
                $distribution->voucher_distributionrespond_timestamp = NOW();
                $distribution->created_by_user_name = $this->createdBy;
                $distribution->last_updated_by_user_name = $this->createdBy;
                $distribution->save();
            }
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function sendSMS($voucher)
    {
        $SMS_GATEWAY_USER = 'Prezent';
        $SMS_GATEWAY_PASSWORD = 'Kd47Msd';

        $handphone = $voucher->campaign_recipient_phone;
        $smsMessageBody = $voucher->campaign_message_sms;
        if ($handphone) {

            $messageBody = str_replace(' ', '+', $smsMessageBody);
            $url = 'http://smsgw.sprintasia.net:8085/api/msg.php?u=';
            $url .= $SMS_GATEWAY_USER . '&p=' . $SMS_GATEWAY_PASSWORD . '&d=';
            $url .= $handphone . '&m=' . $messageBody;

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $url);
            $response = $response->getBody()->getContents();
            Log::info($response);
            Log::info($url);

            return $response;
        }
    }
}

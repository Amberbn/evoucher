<?php

namespace App\Jobs;

use App\Config;
use App\VoucherDistributionTracker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;

class SendSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $voucher;
    public $vouchergenerate;
    public $createdBy;
    public function __construct($voucher ,$vouchergenerate, $createdBy)
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
        try {
            DB::beginTransaction();

            $voucher = $this->voucher;
            $vouchergenerate = $this->vouchergenerate;

            \Log::info('send sms job outside voucher for number '. $voucher->campaign_recipient_phone .' is running on ' . date('Y-m-d H:i:s'));

            $smsResponseCodeConfig = Config::where('config_group_name', 'SMS_Respond_Code')
                ->select('config_name', 'config_value')
                ->get();

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

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e);
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
            \Log::info($response);
            \Log::info($url);

            return $response;
        }
    }
}

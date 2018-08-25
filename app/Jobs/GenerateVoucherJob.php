<?php

namespace App\Jobs;

use App\Config;
use App\Jobs\SendSMSJob;
use App\VoucherGenerated;
use App\Jobs\SendEmailJob;
use Illuminate\Bus\Queueable;
use App\VoucherDistributionTracker;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateVoucherJob implements ShouldQueue
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
            $voucherGenerateNo = VoucherGenerated::select('voucher_generated_no')->get()->toArray();
            $randomNumber = rand(9999999999, 1000000000);

            while (in_array($randomNumber, $voucherGenerateNo)) {
                $randomNumber = rand(9999999999, 1000000000);
            }

            $voucher = $this->voucher;
            $createdBy = $this->createdBy;

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

            //check for send sms
            $isDistributeBySms = (int) $voucher->campaign_distribute_by_sms == 1 ? true : false;
            $handphone = $vouchergenerate->campaign_recipient_phone;

            if ($handphone && $isDistributeBySms) {

                if(!env('GENERATE_VOUCHERJOB_IS_SPLIT')) {
                    $this->saveDistributionTrackerSMS($voucher, $vouchergenerate, $createdBy);
                }else{
                    SendSMSJob::dispatch($voucher, $vouchergenerate, $createdBy)->onQueue('SendSMSJob');
                }
            }

            //check for send email
            $isDistributeByEmail = (int) $voucher->campaign_distribute_by_email == 1 ? true : false;
            $email = $vouchergenerate->campaign_recipient_email;

            if ($email && $isDistributeByEmail) {

                if (!env('GENERATE_VOUCHERJOB_IS_SPLIT')) {
                    $this->sendEmail($voucher, $vouchergenerate, $createdBy);
                } else {
                    SendEmailJob::dispatch($voucher, $vouchergenerate, $createdBy)->onQueue('SendEmailJob');
                }
            }
            
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }

    public function sendEmail($voucher, $vouchergenerate, $createdBy)
    {
        \Log::info('send sms email inside voucher for number ' . $voucher->campaign_recipient_email . ' is running on ' . date('Y-m-d H:i:s'));

        $sendgridApiKey = env('SENDGRID_API_KEY');

        $emailfrom = env('MAIL_FROM_ADDRESS');
        $subject = $voucher->campaign_message_title;
        $emailSendTo = $vouchergenerate->campaign_recipient_email;
        $contentType = "text/plain";
        $emailContent = $voucher->campaign_message_body;

        $buildEmail = new \SendGrid\Mail\Mail();
        $buildEmail->setFrom($emailfrom);
        $buildEmail->setSubject($subject);
        $buildEmail->addTo($emailSendTo);
        $buildEmail->addContent($contentType, $emailContent);

        $sendgrid = new \SendGrid($sendgridApiKey);
        try {
            $response = $sendgrid->send($buildEmail);
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }

    public function saveDistributionTrackerSMS($voucher, $vouchergenerate, $createdBy)
    {
        \Log::info('send sms job inside voucher for number ' . $voucher->campaign_recipient_phone . ' is running on ' . date('Y-m-d H:i:s'));

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

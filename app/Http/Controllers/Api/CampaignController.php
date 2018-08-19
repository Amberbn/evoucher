<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Repository\CampaignRepository;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignController extends ApiController
{
    /**
     *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
     */
    public function __construct()
    {
        $this->repository = new CampaignRepository;
    }

    /**
     *FUNCTION FOR GET ALL DATA CAMPAIGN
     *@return \Illuminate\Http\Response
     */
    public function getCampaigns()
    {
        return $this->repository->getCampaign();
    }

    /**
     *FUNCTION FOR GET DETAIL CAMPAIGN
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function getCampaign($campaignId)
    {
        return $this->repository->getCampaign($campaignId);
    }

    /**
     *FUNCTION FOR GET CAMPAIGN VOUCHER
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function getCampaignVouchers()
    {
        return $this->repository->getCampaignVoucher();
    }

    /**
     *FUNCTION FOR GET DETAIL CAMPAIGN VOUCHER
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function getCampaignVoucher($campaignVoucherId)
    {
        return $this->repository->getCampaignVoucher($campaignVoucherId);
    }

    /**
     *FUNCTION FOR GET DETAIL CAMPAIGN RECIPIENT
     *@return \Illuminate\Http\Response
     */
    public function getCampaignRecipients()
    {
        return $this->repository->getCampaignRecipient();
    }

    /**
     *FUNCTION FOR GET DETAIL CAMPAIGN VOUCHER
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function getCampaignRecipient($campaignVoucherId)
    {
        return $this->repository->getCampaignRecipient($campaignVoucherId);
    }

    /**
     *FUNCTION FOR CREATE CAMPAIGN VOUCHER
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function createCampaign(Request $request)
    {
        
        $error = $this->validateStep($request);
        if (!$error) {
             return $this->repository->createCampaign($request);
        }

        return $errors;
    }

    public function createRecipient(Request $request)
    {
        $errors = $this->validateCreateRecipient($request);

        if(!$errors) {
            return $this->repository->storeStepFour($request);
        }

        return $errors;
    }

    public function openCampaign(Request $request)
    {
        return $this->repository->openCampaign($request);
    }

    public function csv()
    {
        $path = public_path() . '/csv/recipient.csv';
        $excel = Excel::load($path)->get()->toArray();
        return $this->sendSuccess($excel);
    }

    public function validateCreateRecipient($request)
    {
        if ($request->has('recipient') && $request->has('campaign_voucher_id')) {

            $campaignVoucherId = (int)$request->campaign_voucher_id;

            if ($campaignVoucherId <= 0) {
                return $this->sendBadRequest('campaign voucher id is invalid');
            }
            $validator = $this->validateStepFour($request);
            return $this->checkErrorValidation($validator);
          
        }
        return $this->sendBadRequest('invalid input format');
    }

    public function validateStep($request)
    {
        if(!$request->has('step')) {
            return $this->sendNotFound();
        }

        $step = (int)$request->step;

        if($step == 1){
            $validator = $this->validateStepOne($request);
            return $this->checkErrorValidation($validator);
        }

        $campaignId = 0;

        if($request->has('campaignid')) {
            $campaignId = (int)$request->campaignid;
        }

        if ($campaignId > 0 && $step > 0) {

            if ($step == 2) {

                $validator = $this->validateStepTwo($request);

                return $this->checkErrorValidation($validator);

            }

            if ($step == 3 && $request->has('voucher')) {

                $validator = $this->validateStepThree($request);

                return $this->checkErrorValidation($validator);
            }
        }

        return $this->sendBadRequest('invalid input format');
    }

    public function validateStepOne($request)
    {
        $input = $request->all();
        $rules = [
            'campaign_category_pid' => 'required|integer',
            'campaign_title' => 'required|min:5',
            'step' => 'required|integer|in:1',
        ];

        return Validator::make($input, $rules);
    }

    public function validateStepTwo($request)
    {
        $input = $request->all();
        $rules = [
            'campaign_message_title' => 'required|min:5',
            'campaign_message_body' => 'required|min:5',
            'campaign_message_sms' => 'required|min:5',
            'campaign_period_start_date' => 'required',
            'campaign_period_end_date' => 'required',
            'step' => 'required|integer|in:2',
            'campaignid' => 'required|integer',
        ];

        return Validator::make($input, $rules);
    }

    public function validateStepThree($request)
    {
        if ($request->has('voucher')) {

            $input = $request->all();
            $rules = [
                'voucher' => 'required|array',
                'voucher.*.voucher_catalog_id' => 'required|integer',
                'voucher.*.campaign_voucher_unit_quantity' =>
                    'required|integer',
                'step' => 'required|integer|in:3',
                'campaignid' => 'required|integer',
            ];

            return Validator::make($input, $rules);
        }
    }

    public function validateStepFour($request)
    {
        if ($request->has('recipient')) {

            $input = $request->all();
            $rules = [
                'recipient' => 'required|array',
                'recipient.*.salutation' => 'required|min:2',
                'recipient.*.name' => 'required',
                'recipient.*.phone' => 'required',
                // 'recipient.*.phone' => 'required|regex:/^\d{10,14}$/',
                //'recipient.*.phone' => 'required|regex:/^(^\+62\s?|^62\s?|^0|^8)(\d{3,4}-?){2}\d{3,4}$/g',
                'recipient.*.email' => 'required|email',
                'campaign_voucher_id' => 'required|integer',
            ];

            return Validator::make($input, $rules);
        }
    }

    public function checkErrorValidation($validator)
    {
        if ($validator->fails()) {
            $failedRules = $validator->failed();
            $errors = $validator->errors()->getMessages();
            return $errors;
        }
        return null;
    }

}

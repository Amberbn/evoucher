<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Repository\CampaignRepository;
use Excel;
use Illuminate\Http\Request;

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
        return $this->repository->createCampaign($request);
    }

    public function createRecipient(Request $request)
    {
        return $this->repository->storeStepFour($request);
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

}

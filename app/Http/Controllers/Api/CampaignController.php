<?php

namespace App\Http\Controllers\Api;

use App\Campaign;
use App\Http\Controllers\Api\ApiController;
use App\Repository\CampaignRepository;
use DB;
use Excel;
use Illuminate\Http\Request;

class CampaignController extends ApiController
{
    /**
     *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
     */
    public function __construct()
    {
        $this->model = new Campaign;
        $this->repository = new CampaignRepository;
    }

    public function campaignMessage()
    {
        return [
            'create_recipient' => 'Request data not found or quantity is not enough',
        ];
    }

    /**
     *FUNCTION FOR SET FILTER CLIENT
     *@return Array $filter
     */
    public function campaignFilter()
    {
        $filter = [
            'orderBy' => 'campaign_code',
            'filter_1' => 'campaign_code',
            'filter_2' => 'campaign_title',
            'filter_3' => 'campaign_status',
        ];

        return $filter;

    }

    /**
     *FUNCTION FOR GET ALL DATA CAMPAIGN
     *@return \Illuminate\Http\Response
     */
    public function getCampaigns($campaignId = null)
    {
        $campaign = $this->repository->getCampaign($campaignId);

        if (empty($campaign->get()->toarray())) {
            return $this->sendNotfound();
        }
        $filter = $this->campaignFilter();

        return $this->dataTableResponseBuilder($campaign, $filter);

    }

    /**
     *FUNCTION FOR GET DETAIL CAMPAIGN
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function getCampaign($campaignId)
    {
        if (!(int) $campaignId) {
            return $this->sendNotfound();
        }

        $campaign = $this->repository->getCampaign($campaignId)->get()->toArray();
        if (empty($campaign)) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($campaign);
    }

    public function createCampaign(Request $request)
    {
        try {
            DB::beginTransaction();
            $campaign = $this->repository->createCampaign($request);
            DB::commit();
            if (!$campaign) {
                return $this->sendNotfound();
            }
            return $this->sendCreated($campaign);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
    }

    public function createRecipient(Request $request)
    {
        try {
            DB::beginTransaction();
            $campaign = $this->repository->storeStepFour($request);
            DB::commit();

            if (!$campaign) {
                return $this->sendBadRequest($this->campaignMessage()['create_recipient']);
            }

            return $this->sendCreated($campaign);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
    }

    public function csv()
    {
        $path = public_path() . '/csv/recipient.csv';
        $excel = Excel::load($path)->get()->toArray();
        return $this->sendSuccess($excel);
    }

}

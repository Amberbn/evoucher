<?php
namespace App\Repository;

use App\Campaign;
use App\Campaignvoucher;
use App\VoucherGenerated;
use App\CampaignRecipient;
use App\VoucherCatalogOutlet;
use App\CampaignVoucherOutlet;
use App\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Http\Repository\VoucherCatalogRepository;

class CampaignRepository extends BaseRepository
{
    private $step = [1, 2, 3];

    public function __construct()
    {
        $this->model = new Campaign;
        $this->campaignVoucher = new CampaignVoucher;
        $this->campaignRecipient = new CampaignRecipient;
        $this->voucherCatalogOutlet = new VoucherCatalogOutlet;        
        $this->campaignVoucherOutlet = new CampaignVoucherOutlet;
        $this->voucherCatalogRepository = new VoucherCatalogRepository;
        $this->voucherGenerated = new VoucherGenerated;
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
        return [
            'orderBy' => 'campaign_code',
            'filter_1' => 'campaign_code',
            'filter_2' => 'campaign_title',
            'filter_3' => 'campaign_status',
        ];
    }

    public function getCampaign($campaignid = null)
    {
        $table = $this->model->getTable();
        $campaign = $this->model
            ->join('bsn_client as client', function ($join) use ($table) {
                $join
                    ->on('client.client_id', '=', $table . '.client_id');
            })
            ->leftJoin('frm_global_parameters as gp', function ($join) use ($table) {
                $join
                    ->on('gp.parameters_id', '=', $table . '.campaign_category_pid')
                    ->where('gp.parameters_type', '=', 'campaign_category');
            });

        if ($campaignid) {
            $campaign->where($table . '.campaign_id', '=', $campaignid);
        }

        if (!$this->isGroupSprint()) {
            $campaign->where('client.client_category_pid', '=', $this->me()['client_category_pid']);
        }

        $campaign->where($table . '.isactive', '=', true);
        $campaign->where($table . '.isdelete', '=', false);

        $campaign->select(
            $table . '.campaign_id',
            $table . '.campaign_code',
            $table . '.client_id',
            $table . '.campaign_category_pid',
            $table . '.campaign_wizzard_current_step',
            $table . '.campaign_pay_using_point',
            $table . '.campaign_title',
            $table . '.campaign_message_title',
            $table . '.campaign_message_body',
            $table . '.campaign_message_sms',
            $table . '.campaign_method_is_postpaid',
            $table . '.campaign_period_start_date',
            $table . '.campaign_period_end_date',
            $table . '.campaign_distribute_by_email',
            $table . '.campaign_distribute_by_sms',
            $table . '.campaign_sms_charge_amount_grandtotal',
            $table . '.campaign_sms_charge_point_grandtotal',
            $table . '.campaign_voucher_unit_quantity_grandtotal',
            $table . '.campaign_voucher_value_amount_grandtotal',
            $table . '.campaign_voucher_value_point_grandtotal',
            $table . '.campaign_voucher_unit_price_amount_grandtotal',
            $table . '.campaign_sms_charge_point_grandtotal',
            $table . '.campaign_voucher_unit_price_point_grandtotal',
            $table . '.campaign_status',
            $table . '.data_sort',
            $table . '.isactive',
            $table . '.isdelete',
            $table . '.created_at',
            $table . '.created_by_user_name',
            $table . '.updated_at',
            $table . '.last_updated_by_user_name',
            'client.client_name',
            'gp.parameters_value as campaign_category_title'
        );

        if (empty($campaign->get()->toarray())) {
            return $this->sendNotfound();
        }
        $filter = $this->campaignFilter();

        if($campaignid) {
            return $this->sendSuccess($campaign->get()->toArray());
        }

        return $this->dataTableResponseBuilder($campaign, $filter);
    }

    public function getCampaignVoucher($campaignVoucherId = null)
    {
        $table = $this->campaignVoucher->getTable();
        $campaign = $this->campaignVoucher
            ->join('bsn_client as client', function ($join) use ($table) {
                $join
                    ->on('client.client_id', '=', $table . '.client_id');
            })
            ->join('bsn_campaign as campaign', function ($join) use ($table) {
                $join
                    ->on('campaign.campaign_id', '=', $table . '.campaign_id');
            })
            ->leftJoin('frm_global_parameters as gp', function ($join) use ($table) {
                $join
                    ->on('gp.parameters_id', '=', 'campaign.campaign_category_pid')
                    ->where('gp.parameters_type', '=', 'campaign_category');
            });

        if ($campaignVoucherId) {
            $campaign->where($table . '.campaign_voucher_id', '=', $campaignVoucherId);
        }

        if (!$this->isGroupSprint()) {
            $campaign->where('client.client_category_pid', '=', $this->me()['client_category_pid']);
        }

        $campaign->where('campaign.isactive', '=', true);
        $campaign->where('campaign.isdelete', '=', false);

        $campaign->select(
            $table . '.campaign_voucher_id',
            $table . '.voucher_catalog_id',
            $table . '.campaign_id',
            $table . '.client_id',
            $table . '.voucher_catalog_revision_no',
            $table . '.merchant_client_id',
            $table . '.campaign_voucher_sku_code',
            $table . '.campaign_voucher_title',
            $table . '.campaign_voucher_main_image_url',
            $table . '.campaign_voucher_information',
            $table . '.campaign_voucher_terms_and_condition',
            $table . '.campaign_voucher_instruction_customer',
            $table . '.campaign_voucher_instruction_outlet',
            $table . '.campaign_voucher_valid_start_date',
            $table . '.campaign_voucher_valid_end_date',
            $table . '.campaign_voucher_tags',
            $table . '.campaign_voucher_unit_quantity',
            $table . '.campaign_voucher_unit_cogs_amount',
            $table . '.campaign_voucher_value_amount',
            $table . '.campaign_voucher_value_point',
            $table . '.campaign_voucher_unit_price_amount',
            $table . '.campaign_voucher_unit_price_point',
            $table . '.campaign_sms_charge_amount_subtotal',
            $table . '.campaign_sms_charge_point_subtotal',
            $table . '.campaign_voucher_value_amount_subtotal',
            $table . '.campaign_voucher_value_point_subtotal',
            $table . '.campaign_voucher_unit_price_amount_subtotal',
            $table . '.campaign_voucher_unit_price_point_subtotal',
            $table . '.data_sort',
            $table . '.created_at',
            $table . '.created_by_user_name',
            'campaign.campaign_title',
            'campaign.campaign_code',
            'campaign.campaign_status'
        );

        if (empty($campaign->get()->toarray())) {
            return $this->sendNotfound();
        }
        $filter = $this->campaignFilter();

        if($campaignVoucherId) {
            return $this->sendSuccess($campaign->get()->toArray());
        }
        return $this->dataTableResponseBuilder($campaign, $filter);

    }

    public function getCampaignRecipient($campaignRecipientId = null)
    {
        $table = $this->campaignRecipient->getTable();
        $recipient = $this->campaignRecipient
            ->join('bsn_client as client', function ($join) use ($table) {
                $join
                    ->on('client.client_id', '=', $table . '.client_id');
            })
            ->join('bsn_campaign as campaign', function ($join) use ($table) {
                $join
                    ->on('campaign.campaign_id', '=', $table . '.campaign_id');
            })
            ->leftJoin('frm_global_parameters as gp', function ($join) use ($table) {
                $join
                    ->on('gp.parameters_id', '=', 'campaign.campaign_category_pid')
                    ->where('gp.parameters_type', '=', 'campaign_category');
            });

        if ($campaignRecipientId) {
            $recipient->where($table . '.campaign_recipient_id', '=', $campaignRecipientId);
        }

        if (!$this->isGroupSprint()) {
            $recipient->where('client.client_category_pid', '=', $this->me()['client_category_pid']);
        }

        $recipient->where('campaign.isactive', '=', true);
        $recipient->where('campaign.isdelete', '=', false);

        $recipient->select(
            $table . '.campaign_recipient_id',
            $table . '.campaign_voucher_id',
            $table . '.campaign_id',
            $table . '.client_id',
            $table . '.campaign_recipient_salutation',
            $table . '.campaign_recipient_name',
            $table . '.campaign_recipient_phone',
            $table . '.campaign_recipient_email',
            'campaign.campaign_title',
            'campaign.campaign_code',
            'campaign.campaign_status'
        );
        if (empty($recipient->get()->toarray())) {
            return $this->sendNotfound();
        }
        $filter = $this->campaignFilter();
        
        if($campaignRecipientId) {
            return $this->sendSuccess($recipient->get()->toArray());
        }

        return $this->dataTableResponseBuilder($recipient, $filter);
    }

    public function checkValidStep($stepId)
    {
        return in_array($stepId,$this->step);
    }

    public function createCampaign($request)
    {
        $checkstep = (int) $request->step;
        $campaignId = (int) $request->campaignid;
        $campaign = null;
        $checkValidStep = $this->checkValidStep($checkstep);

        if($checkValidStep && !$request->has('campaignid')) {
            return $this->storeStepOne($request);
        }
       
        if($request->has('campaignid')) {
            $campaign = $this->model::where('campaign_id', $campaignId)->first();
        }

        if($campaign && $checkValidStep) {
            if ($checkstep == 2 && $campaign != null) {
                return $this->storeStepTwo($request, $campaign);
            } elseif ($checkstep == 3 && $campaign != null) {
                return $this->storeStepThree($request, $campaign);
            }

            return $this->sendNotfound();
        }

        return $this->sendNotfound();
    }

    public function storeStepOne($request)
    {
        //step 1 campaign profile
        $clientId = $this->me()['client_id'];

        if (!$this->isGroupSprint()) {
            $clientId = $request->input('client_id');
        }

        try {
            DB::beginTransaction();

            $campaign = $this->model;
            $campaign->campaign_code = str_random(32);
            $campaign->client_id = $clientId;
            $campaign->campaign_category_pid = $request->input('campaign_category_pid');
            $campaign->campaign_wizzard_current_step = 1;
            $campaign->campaign_pay_using_point = $request->input('campaign_pay_using_point') ?: false;
            $campaign->campaign_title = $request->input('campaign_title');
            $campaign->campaign_status = 'draft';
            $campaign->created_by_user_name = $this->loginUsername();
            $campaign->save();
            DB::commit();

            if (!$campaign) {
                return $this->sendNotfound();
            }

            return $this->sendCreated($campaign);

        }catch(\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
    }

    public function storeStepTwo($request, $campaign)
    {
        //step 2 campaign message
        try {
            DB::beginTransaction();

            $campaign->campaign_message_title = $request->input('campaign_message_title');
            $campaign->campaign_message_body = $request->input('campaign_message_body');
            $campaign->campaign_message_sms = $request->input('campaign_message_sms');
            $campaign->campaign_method_is_postpaid = $request->input('campaign_method_is_postpaid') ?: false;
            $campaign->campaign_period_start_date = $request->input('campaign_period_start_date') ?: NOW();
            $campaign->campaign_period_end_date = $request->input('campaign_period_end_date');
            $campaign->campaign_distribute_by_email = $request->input('campaign_distribute_by_email') ?: false;
            $campaign->campaign_distribute_by_sms = $request->input('campaign_distribute_by_sms') ?: false;
            $campaign->campaign_wizzard_current_step = 2;
            $campaign->last_updated_by_user_name = $this->loginUsername();
            $campaign->save();
            DB::commit();

            if (!$campaign) {
                return $this->sendNotfound();
            }
            return $this->sendCreated($campaign);
        }catch(\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
    }

    public function storeStepThree($request, $campaign)
    {
        //step 3 campaign periode

        //set initial value default
        $unitQuantityGrandtotal = 0;
        $valueAmountGrandTotal = 0;
        $valuePointGrandTotal = 0;
        $unitPriceAmountGrandTotal = 0;
        $unitPricePointGrandTotal = 0;
        try {
            DB::beginTransaction();

            $voucherCampaign = [];
            foreach ($request->voucher as $voucherRequest) {

                //get value from voucher catalog
                $voucherCatalog = $this->campaignVoucher
                    ->where('voucher_catalog_id', $voucherRequest['voucher_catalog_id'])
                    ->first();

                //set alias because to long code
                $unitQuantity = $voucherRequest['campaign_voucher_unit_quantity'];
                $valueAmount = $voucherCatalog->campaign_voucher_value_amount;
                $valuePoint = $voucherCatalog->campaign_voucher_value_point;
                $unitPriceAmount = $voucherCatalog->campaign_voucher_unit_price_amount;
                $unitPricePoint = $voucherCatalog->campaign_voucher_unit_price_point;
                $revisionNumber = $voucherCatalog->voucher_catalog_revision_no;
                $catalogId = $voucherCatalog->voucher_catalog_id;
                $campaignId = $campaign->campaign_id;

                //assign value to table campaign voucher
                $voucher = new Campaignvoucher;
                $voucher->voucher_catalog_id = $catalogId;
                $voucher->voucher_catalog_revision_no = $revisionNumber;
                $voucher->campaign_id = $campaignId;
                $voucher->client_id = $campaign->client_id;

                //copy data from voucher catalog
                $voucher->voucher_catalog_revision_no = $voucherCatalog->voucher_catalog_revision_no;
                $voucher->merchant_client_id = $voucherCatalog->merchant_client_id;
                $voucher->campaign_voucher_sku_code = $voucherCatalog->campaign_voucher_sku_code;
                $voucher->campaign_voucher_title = $voucherCatalog->campaign_voucher_title;
                $voucher->campaign_voucher_main_image_url = $voucherCatalog->campaign_voucher_main_image_url;
                $voucher->campaign_voucher_information = $voucherCatalog->campaign_voucher_information;
                $voucher->campaign_voucher_terms_and_condition = $voucherCatalog->campaign_voucher_terms_and_condition;
                $voucher->campaign_voucher_instruction_customer = $voucherCatalog->campaign_voucher_instruction_customer;
                $voucher->campaign_voucher_instruction_outlet = $voucherCatalog->campaign_voucher_instruction_outlet;
                $voucher->campaign_voucher_valid_start_date = $voucherCatalog->campaign_voucher_valid_start_date;
                $voucher->campaign_voucher_valid_end_date = $voucherCatalog->campaign_voucher_valid_end_date;
                $voucher->campaign_voucher_tags = $voucherCatalog->campaign_voucher_tags;
                $voucher->campaign_voucher_unit_quantity = $voucherCatalog->campaign_voucher_unit_quantity;
                $voucher->campaign_voucher_unit_cogs_amount = $voucherCatalog->campaign_voucher_unit_cogs_amount;
                $voucher->data_sort = $voucherCatalog->data_sort;

                //calculate per voucher
                $voucher->campaign_voucher_unit_quantity = $unitQuantity;
                $voucher->campaign_voucher_value_amount = $valueAmount;
                $voucher->campaign_voucher_value_point = $valuePoint;
                $voucher->campaign_voucher_unit_price_amount = $unitPriceAmount;
                $voucher->campaign_voucher_unit_price_point = $unitPricePoint;
                $voucher->campaign_voucher_value_amount_subtotal = ($valueAmount * $unitQuantity);
                $voucher->campaign_voucher_value_point_subtotal = ($valuePoint * $unitQuantity);
                $voucher->campaign_voucher_unit_price_amount_subtotal = ($unitPriceAmount * $unitQuantity);
                $voucher->campaign_voucher_unit_price_point_subtotal = ($unitPricePoint * $unitQuantity);
                $voucher->created_by_user_name = $this->loginUsername();
                $voucher->created_at = NOW();
                $voucher->save();

                //update decrement stock catalog
                $stock = new VoucherCatalogRepository;
                $stock->stockTransaction($catalogId, 'CAMPAIGN', $campaignId, $unitQuantity);

                //set increment for grand total used
                $unitQuantityGrandtotal += $unitQuantity;
                $valueAmountGrandTotal += ($valueAmount * $unitQuantity);
                $valuePointGrandTotal += ($valuePoint * $unitQuantity);
                $unitPriceAmountGrandTotal += ($unitPriceAmount * $unitQuantity);
                $unitPricePointGrandTotal += ($unitPricePoint * $unitQuantity);
            }

            //update bsn campaign for step 3
            $campaign->campaign_wizzard_current_step = 3;
            $campaign->campaign_voucher_unit_quantity_grandtotal = $unitQuantityGrandtotal;
            $campaign->campaign_voucher_value_amount_grandtotal = $valueAmountGrandTotal;
            $campaign->campaign_voucher_value_point_grandtotal = $valuePointGrandTotal;
            $campaign->campaign_voucher_unit_price_amount_grandtotal = $unitPriceAmountGrandTotal;
            $campaign->campaign_voucher_unit_price_point_grandtotal = $unitPricePointGrandTotal;
            $campaign->campaign_sms_charge_amount_grandtotal = ($unitQuantityGrandtotal * 100);
            $campaign->campaign_sms_charge_point_grandtotal = ($unitQuantityGrandtotal * 2);

            $campaign->data_sort = $request->input('data_sort') ?: 1000;
            $campaign->isactive = $request->input('isactive') ?: true;
            $campaign->isdelete = $request->input('isdelete') ?: false;
            $campaign->last_updated_by_user_name = $this->loginUsername();
            $campaign->save();
            DB::commit();

            if (!$campaign) {
                return $this->sendNotfound();
            }
            return $this->sendCreated(['saved' => true]);
        }catch(\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
    }

    public function storeStepFour($request)
    {
        try {
            DB::beginTransaction();
            //add recipient to voucher
            $unitQuantity = 0;
            $recipients = $request->input('recipient');
            $campaignVoucherId = $request->input('campaign_voucher_id'); 

            //check campaign voucher
            $campaignVoucher = $this->campaignVoucher
                ->where('campaign_voucher_id',$campaignVoucherId)
                ->first();
            
            //check recipient saved
            $campaignRecipientRecord = $this->campaignRecipient
                ->where('campaign_voucher_id', $campaignVoucherId)
                ->count();        
            
            //if data not found
            if(!$campaignVoucher) {
                return $this->sendNotfound();
            }
            //set alias
            $unitQuantity = $campaignVoucher->campaign_voucher_unit_quantity;
        
            //check if saved record recipient in db > or = quantity
            if ($campaignRecipientRecord >= $unitQuantity) {
                return $this->sendBadRequest($this->campaignMessage()['create_recipient']);
            }

            //check if unit quantity < recipient request
            if ($unitQuantity < count($recipients)) {
                return $this->sendBadRequest($this->campaignMessage()['create_recipient']);
            }
    
            //save recipient
            foreach ($recipients as $recipient) {
                $campaignRecipient = new CampaignRecipient;
                $campaignRecipient->campaign_voucher_id = $campaignVoucher->campaign_voucher_id;
                $campaignRecipient->campaign_id = $campaignVoucher->campaign_id;
                $campaignRecipient->client_id = $campaignVoucher->client_id;
                $campaignRecipient->campaign_recipient_salutation = $recipient['salutation'] ?: null;
                $campaignRecipient->campaign_recipient_name = $recipient['name'] ?: null;
                $campaignRecipient->campaign_recipient_phone = $recipient['phone'] ?: null;
                $campaignRecipient->campaign_recipient_email = $recipient['email'] ?: null;
                $campaignRecipient->save();
            }

            $voucherCatalogOutlets = $this->voucherCatalogOutlet
                ->where('voucher_catalog_id',$campaignVoucher->voucher_catalog_id)
                ->get();
            
            if(!$voucherCatalogOutlets){
                return $this->sendNotfound();
            }

            foreach($voucherCatalogOutlets as $voucherCatalogOutlet) {
                $campaignVoucherOutlet = new CampaignVoucherOutlet;
                $campaignVoucherOutlet->campaign_voucher_id = $campaignVoucher->campaign_voucher_id;
                $campaignVoucherOutlet->voucher_catalog_id = $campaignVoucher->voucher_catalog_id;
                $campaignVoucherOutlet->campaign_id = $campaignVoucher->campaign_id;
                $campaignVoucherOutlet->outlets_id = $voucherCatalogOutlet->outlets_id;
                $campaignVoucherOutlet->merchant_id = $voucherCatalogOutlet->merchant_id;
                $campaignVoucherOutlet->created_at = $voucherCatalogOutlet->created_at;
                $campaignVoucherOutlet->created_by_user_name = $voucherCatalogOutlet->created_by_user_name;
                $campaignVoucherOutlet->save();
            }

            DB::commit();
            
            return $this->sendCreated(['saved' => true]);
        }catch(\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
    }

    public function openCampaign($request)
    {
        try {
            DB::beginTransaction();

            $campaign = $this->model::where('campaign_id', $request->campaign_id)
                ->first();
            if(!$campaign) {
                return $this->sendNotfound();
            }

            $voucherCatalog = $this->campaignVoucher
                ->where('voucher_catalog_id', $request->voucher_catalog_id)
                ->first();

            if (!$voucherCatalog) {
                return $this->sendNotfound();
            }


            $recipients = $request->recipient;

            //set alias because to long code
            $unitQuantity = 1;
            $valueAmount = $voucherCatalog->campaign_voucher_value_amount;
            $valuePoint = $voucherCatalog->campaign_voucher_value_point;
            $unitPriceAmount = $voucherCatalog->campaign_voucher_unit_price_amount;
            $unitPricePoint = $voucherCatalog->campaign_voucher_unit_price_point;
            $revisionNumber = $voucherCatalog->voucher_catalog_revision_no;
            $catalogId = $voucherCatalog->voucher_catalog_id;
            $campaignId = $campaign->campaign_id;

            //assign value to table campaign voucher
            $voucher = new Campaignvoucher;
            $voucher->voucher_catalog_id = $catalogId;
            $voucher->voucher_catalog_revision_no = $revisionNumber;
            $voucher->campaign_id = $campaignId;
            $voucher->client_id = $campaign->client_id;

            //copy data from voucher catalog
            $voucher->voucher_catalog_revision_no = $voucherCatalog->voucher_catalog_revision_no;
            $voucher->merchant_client_id = $voucherCatalog->merchant_client_id;
            $voucher->campaign_voucher_sku_code = $voucherCatalog->campaign_voucher_sku_code;
            $voucher->campaign_voucher_title = $voucherCatalog->campaign_voucher_title;
            $voucher->campaign_voucher_main_image_url = $voucherCatalog->campaign_voucher_main_image_url;
            $voucher->campaign_voucher_information = $voucherCatalog->campaign_voucher_information;
            $voucher->campaign_voucher_terms_and_condition = $voucherCatalog->campaign_voucher_terms_and_condition;
            $voucher->campaign_voucher_instruction_customer = $voucherCatalog->campaign_voucher_instruction_customer;
            $voucher->campaign_voucher_instruction_outlet = $voucherCatalog->campaign_voucher_instruction_outlet;
            $voucher->campaign_voucher_valid_start_date = $voucherCatalog->campaign_voucher_valid_start_date;
            $voucher->campaign_voucher_valid_end_date = $voucherCatalog->campaign_voucher_valid_end_date;
            $voucher->campaign_voucher_tags = $voucherCatalog->campaign_voucher_tags;
            $voucher->campaign_voucher_unit_quantity = $voucherCatalog->campaign_voucher_unit_quantity;
            $voucher->campaign_voucher_unit_cogs_amount = $voucherCatalog->campaign_voucher_unit_cogs_amount;
            $voucher->data_sort = $voucherCatalog->data_sort;

            //calculate per voucher
            $voucher->campaign_voucher_unit_quantity = $unitQuantity;
            $voucher->campaign_voucher_value_amount = $valueAmount;
            $voucher->campaign_voucher_value_point = $valuePoint;
            $voucher->campaign_voucher_unit_price_amount = $unitPriceAmount;
            $voucher->campaign_voucher_unit_price_point = $unitPricePoint;
            $voucher->campaign_voucher_value_amount_subtotal = ($valueAmount * $unitQuantity);
            $voucher->campaign_voucher_value_point_subtotal = ($valuePoint * $unitQuantity);
            $voucher->campaign_voucher_unit_price_amount_subtotal = ($unitPriceAmount * $unitQuantity);
            $voucher->campaign_voucher_unit_price_point_subtotal = ($unitPricePoint * $unitQuantity);
            $voucher->created_by_user_name = $this->loginUsername();
            $voucher->created_at = NOW();
            $voucher->save();

            //update decrement stock catalog
            $stock = new VoucherCatalogRepository;
            $stock->stockTransaction($catalogId, 'CAMPAIGN', $campaignId, $unitQuantity);

            //check campaign voucher
            $campaignVoucher = $this->campaignVoucher
                ->where('campaign_voucher_id', $voucher->campaign_voucher_id)
                ->first();

            //check recipient saved
            $campaignRecipientRecord = $this->campaignRecipient
                ->where('campaign_voucher_id', $voucher->campaign_voucher_id)
                ->count();

            //if data not found
            if (!$campaignVoucher) {
                return $this->sendNotfound();
            }

            //set alias
            $unitQuantity = $campaignVoucher->campaign_voucher_unit_quantity;

            //check if saved record recipient in db > or = quantity
            if ($campaignRecipientRecord >= $unitQuantity) {
                return $this->sendBadRequest($this->campaignMessage()['create_recipient']);
            }

            //check if unit quantity < recipient request
            if ($unitQuantity < count($recipients)) {
                return $this->sendBadRequest($this->campaignMessage()['create_recipient']);
            }

            //save recipient
            $campaignRecipient = new CampaignRecipient;
            $campaignRecipient->campaign_voucher_id = $campaignVoucher->campaign_voucher_id;
            $campaignRecipient->campaign_id = $campaignVoucher->campaign_id;
            $campaignRecipient->client_id = $campaignVoucher->client_id;
            $campaignRecipient->campaign_recipient_salutation = $recipients[0]['salutation'] ?: null;
            $campaignRecipient->campaign_recipient_name = $recipients[0]['name'] ?: null;
            $campaignRecipient->campaign_recipient_phone = $recipients[0]['phone'] ?: null;
            $campaignRecipient->campaign_recipient_email = $recipients[0]['email'] ?: null;
            $campaignRecipient->save();

            //check record generate voucher
            $vouchersGenerate = $this->voucherGenerated
                ->where('campaign_id', $campaignId)
                ->where('campaign_voucher_id', $campaignVoucher->campaign_voucher_id)
                ->where('campaign_recipient_id', $campaignRecipient->campaign_recipient_id)
                ->where('client_id', $campaignRecipient->client_id)
                ->count();
            
            //generate new voucher by one
            if($vouchersGenerate == 0) {
                
                $generateNewVouchers = DB::table('vw_voucher_generated')
                ->where('campaign_id', $campaignId)
                ->where('campaign_voucher_id', $campaignVoucher->campaign_voucher_id)
                ->where('campaign_recipient_id', $campaignRecipient->campaign_recipient_id)
                ->where('client_id', $campaignRecipient->client_id)
                ->first();
                
                //copy data to generated voucher
                $vouchergenerate = new VoucherGenerated;
                $vouchergenerate->campaign_voucher_id = $campaignVoucher->campaign_voucher_id;
                $vouchergenerate->voucher_generated_no = $generateNewVouchers->voucher_generated_no;
                $vouchergenerate->campaign_id = $generateNewVouchers->campaign_id;
                $vouchergenerate->client_id = $generateNewVouchers->client_id;
                $vouchergenerate->campaign_recipient_id = $generateNewVouchers->campaign_recipient_id;
                $vouchergenerate->campaign_recipient_salutation = $generateNewVouchers->campaign_recipient_salutation;
                $vouchergenerate->campaign_recipient_name = $generateNewVouchers->campaign_recipient_name;
                $vouchergenerate->campaign_recipient_phone = $generateNewVouchers->campaign_recipient_phone;
                $vouchergenerate->campaign_recipient_email = $generateNewVouchers->campaign_recipient_email;
                $vouchergenerate->voucher_generated_is_redeemed = $generateNewVouchers->voucher_generated_is_redeemed;
                $vouchergenerate->voucher_generated_redeem_id = $generateNewVouchers->voucher_generated_redeem_id;
                $vouchergenerate->voucher_generated_locked_till = $generateNewVouchers->voucher_generated_locked_till;
                $vouchergenerate->save();

            }

            //prepare catalog outlet
            $voucherCatalogOutlets = $this->voucherCatalogOutlet
                ->where('voucher_catalog_id', $campaignVoucher->voucher_catalog_id)
                ->get();

            if (!$voucherCatalogOutlets) {
                return $this->sendNotfound();
            }

            //copy catalog outlet to voucher catalog outlet
            foreach ($voucherCatalogOutlets as $voucherCatalogOutlet) {
                $campaignVoucherOutlet = new CampaignVoucherOutlet;
                $campaignVoucherOutlet->campaign_voucher_id = $campaignVoucher->campaign_voucher_id;
                $campaignVoucherOutlet->voucher_catalog_id = $campaignVoucher->voucher_catalog_id;
                $campaignVoucherOutlet->campaign_id = $campaignVoucher->campaign_id;
                $campaignVoucherOutlet->outlets_id = $voucherCatalogOutlet->outlets_id;
                $campaignVoucherOutlet->merchant_id = $voucherCatalogOutlet->merchant_id;
                $campaignVoucherOutlet->created_at = $voucherCatalogOutlet->created_at;
                $campaignVoucherOutlet->created_by_user_name = $voucherCatalogOutlet->created_by_user_name;
                $campaignVoucherOutlet->save();
            }

            DB::commit();
            return $this->sendCreated(['saved' => true]);

        }catch(\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);

        }
    }
}

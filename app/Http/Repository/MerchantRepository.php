<?php
namespace App\Repository;

use App\Merchant;
use App\Repository\BaseRepository;
use DB;


/**
 *
 */
class MerchantRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Merchant;
    }
    
        /**
     *FUNCTION FOR SET FILTER CLIENT
     *@return Array $filter
     */
    public function merchantFilter()
    {
        $filter = [
            'orderBy' => 'merchant_code',
            'filter_1' => 'merchant_title',
            'filter_2' => 'merchant_description',
            'filter_3' => 'client_legal_name',
        ];

        return $filter;

    }

    public function getAllMerchants()
    {
        $merchants = DB::table('mch_merchant as mm')
            ->join('bsn_client as bc', 'mm.merchant_client_id', '=', 'bc.client_id')
            ->join('frm_global_parameters as bcat', 'mm.merchant_bussiness_category_pid', '=', 'bcat.parameters_id')
            ->where('mm.isactive', '=', true);
        if (!$this->isGroupSprint()) {
            $merchants->where('bc.client_category_pid', '=', $this->me()['client_category_pid']);
        }

        $merchants->where('mm.isactive', '=', true);
        $merchants->where('mm.isdelete', '=', false);

        $merchants->select(
            'mm.merchant_id',
            'mm.merchant_logo_image_url',
            'mm.merchant_code',
            'mm.merchant_client_id',
            'bc.client_code',
            'bc.client_name',
            'mm.merchant_title',
            'mm.merchant_bussiness_category_pid',
            'bcat.parameters_value as merchant_bussiness_category_title',
            'mm.merchant_description',
            'mm.merchant_tags',
            'mm.data_sort',
            'mm.isactive',
            'mm.isdelete',
            'mm.created_at',
            'mm.created_by_user_name',
            'mm.updated_at',
            'mm.last_updated_by_user_name'
        );

        if (empty($merchants->get()->toArray())) {
            return $this->sendNotfound();
        }
        $filter = $this->merchantFilter();

        return $this->dataTableResponseBuilder($merchants, $filter);
    }

    public function getMerchant($merchantId = null)
    {
        $merchant = $this->model::join('mch_outlets as outlet', 'outlet.merchant_id', '=', 'mch_merchant.merchant_id')
            ->select(
                [
                    'mch_merchant.merchant_id',
                    'mch_merchant.merchant_title'
                ]
            );

        if($merchantId) {
            $merchant = $merchant->where('mch_merchant.merchant_id', $merchantId)->get();
        }

        $merchant = $merchant->where('mch_merchant.isactive',true);
        $merchant = $merchant->where('mch_merchant.isdelete', false);
        $merchant = $merchant->where('outlet.isactive', true);
        $merchant = $merchant->where('outlet.isdelete', false);
        $merchant = $merchant->get();

        if (empty($merchant->toArray())) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($merchant);
    }

    public function saveMerchant($request)
    {
        // dd($request->all());
        DB::beginTransaction();

        try {
            $filename = null;
            if ($request->merchant_logo_image_url) {
                $filename = $this->saveImage($request, 'merchant_logo_image_url', 'merchant');
            }

            $tagsConcat = null;
            if(!empty($request->merchant_tags)) {
                $tagsConcat = implode(',',$request->merchant_tags);
            }

            $merchant = new Merchant;
            $merchant->merchant_code = "DJOURNAL1234";
            $merchant->merchant_client_id = $request->input('merchant_client_id');
            $merchant->merchant_title = $request->input('merchant_title');
            $merchant->merchant_bussiness_category_pid = $request->input('merchant_bussiness_category_pid');
            $merchant->merchant_description = $request->input('merchant_description');
            $merchant->merchant_socmed_url_facebook = $request->input('merchant_socmed_url_facebook');
            $merchant->merchant_socmed_url_twitter = $request->input('merchant_socmed_url_twitter');
            $merchant->merchant_socmed_url_linkedin = $request->input('merchant_socmed_url_linkedin');
            $merchant->merchant_socmed_url_instagram = $request->input('merchant_socmed_url_instagram');
            $merchant->merchant_socmed_url_line = $request->input('merchant_socmed_url_line');
            $merchant->merchant_socmed_url_pinterest = $request->input('merchant_socmed_url_pinterest');
            $merchant->merchant_tags = $tagsConcat;
            $merchant->merchant_logo_image_url = $filename;
            $merchant->data_sort = $request->input('data_sort') ?: 1000;
            $merchant->isactive = $request->input('isactive') ?: true;
            $merchant->isdelete = $request->input('isdelete') ?: false;
            $merchant->created_by_user_name = $this->loginUsername();
            $merchant->last_updated_by_user_name = $this->loginUsername();
            $merchant->save(); 
            DB::commit();

            return $this->sendCreated($merchant);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function getTags()
    {
        $tags = $this->model::select('merchant_tags')->get();

        $tagsArray = [];

        foreach ($tags as $tag) {
            $explode = explode(',',$tag->merchant_tags);
            foreach ($explode as $ex) {
                if($ex == "") {
                    continue;
                }
                $tagsArray[] = $ex;
            }
        }

        if (empty($tags->toArray())) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess(collect($tagsArray)->unique());
    }

    public function getMerchantById($merchantId)
    {
         $merchants = DB::table('mch_merchant as mm')
            ->join('bsn_client as bc', 'mm.merchant_client_id', '=', 'bc.client_id')
            ->join('frm_global_parameters as bcat', 'mm.merchant_bussiness_category_pid', '=', 'bcat.parameters_id')
            ->where('mm.isactive', '=', true)
            ->where('mm.merchant_id', $merchantId);
        if (!$this->isGroupSprint()) {
            $merchants->where('bc.client_category_pid', '=', $this->me()['client_category_pid']);
        }

        $merchants->select(
            'mm.merchant_id',
            'mm.merchant_code',
            'mm.merchant_client_id',
            'bc.client_code',
            'bc.client_name',
            'mm.merchant_title',
            'mm.merchant_bussiness_category_pid',
            'bcat.parameters_value as merchant_bussiness_category_title',
            'mm.merchant_description',
            'mm.merchant_socmed_url_facebook',
            'mm.merchant_socmed_url_twitter',
            'mm.merchant_socmed_url_linkedin',
            'mm.merchant_socmed_url_instagram',
            'mm.merchant_socmed_url_line',
            'mm.merchant_socmed_url_pinterest',
            'mm.merchant_tags',
            'mm.data_sort',
            'mm.isactive',
            'mm.isdelete',
            'mm.created_at',
            'mm.created_by_user_name',
            'mm.updated_at',
            'mm.last_updated_by_user_name'
        );

        if (empty($merchants->get()->toArray())) {
            return $this->sendNotfound();
        }
        $filter = $this->merchantFilter();

        return $this->dataTableResponseBuilder($merchants, $filter);
    }

    public function updateMerchant($request, $merchantId)
    {
       
        $merchant = $this->model::where('merchant_id', $merchantId)->first();
        $tagsConcat = null;
        if(!empty($request->merchant_tags)) {
            $tagsConcat = implode(',',$request->merchant_tags);
        }

        if (!$merchant) {
            return $this->sendNotfound();
        }

        DB::beginTransaction();

        try {
            $merchant->merchant_client_id = $request->input('merchant_client_id');
            $merchant->merchant_title = $request->input('merchant_title');
            $merchant->merchant_bussiness_category_pid = $request->input('merchant_bussiness_category_pid');
            $merchant->merchant_description = $request->input('merchant_description');
            $merchant->merchant_socmed_url_facebook = $request->input('merchant_socmed_url_facebook');
            $merchant->merchant_socmed_url_twitter = $request->input('merchant_socmed_url_twitter');
            $merchant->merchant_socmed_url_linkedin = $request->input('merchant_socmed_url_linkedin');
            $merchant->merchant_socmed_url_instagram = $request->input('merchant_socmed_url_instagram');
            $merchant->merchant_socmed_url_line = $request->input('merchant_socmed_url_line');
            $merchant->merchant_socmed_url_pinterest = $request->input('merchant_socmed_url_pinterest');
            $merchant->merchant_tags = $tagsConcat;
            $merchant->data_sort = $request->input('data_sort') ?: 1000;
            $merchant->isactive = $request->input('isactive') ?: true;
            $merchant->isdelete = $request->input('isdelete') ?: false;
            $merchant->last_updated_by_user_name = $this->loginUsername();
             if ($request->file('merchant_logo_image_url')) {
                $filename = $this->saveImage($request, 'merchant_logo_image_url', 'merchant');
                $merchant->merchant_logo_image_url = $filename;
            }

            $merchant->save();

            DB::commit();

            return $this->sendSuccess($merchant);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function delete($merchantId)
    {
         $merchant = $this->model::where('merchant_id', $merchantId)->first();

        if (!$merchant) {
            return $this->sendNotfound();
        }

        try {
            DB::beginTransaction();
            $merchant->isdelete = true;
            $merchant->last_updated_by_user_name = $this->loginUsername();
            $merchant->save();
            DB::commit();

            return $this->sendSuccess($merchant);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
    }

    public function multipleDelete($arraysId)
    {
        try {
            DB::beginTransaction();

            foreach ($arraysId as $merchantId) {
                $merchant = $this->model::where('merchant_id', $merchantId)->first();
                $merchant->isdelete = true;
                $merchant->last_updated_by_user_name = $this->loginUsername();
                $merchant->save();
                DB::commit();
            }
            return $this->sendSuccess(true);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
    }
}

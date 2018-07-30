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
        $this->model = new Merchant();
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

    public function saveMerchant($request)
    {
        DB::beginTransaction();

        try {
            $merchant = new Merchant;
            $merchant->merchant_code = $request->input('merchant_code');
            $merchant->merchant_client_id = $request->input('merchant_client_id');
            $merchant->merchant_title = $request->input('merchant_title');
            $merchant->merchant_bussiness_category_pid = $request->input('merchant_bussiness_category_pid');
            $merchant->merchant_description = $request->input('merchant_description');
            $merchant->merchant_tags = $request->input('merchant_tags');
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

    public function getMerchantById($merchantId)
    {
        $merchant = Merchant::find($merchantId);

        if (empty($merchant)) {
            return $this->sendNotfound();
        }
        return $this->sendSuccess($merchant);
    }

    public function updateMerchant($request, $merchant)
    {
        $merchant = $this->model::where('merchant_id', $merchantId)->first();

        if (!$merchant) {
            return $this->sendNotfound();
        }

        DB::beginTransaction();

        try {
            $merchant->merchant_code = $request->input('merchant_code');
            $merchant->merchant_client_id = $request->input('merchant_client_id');
            $merchant->merchant_title = $request->input('merchant_title');
            $merchant->merchant_bussiness_category_pid = $request->input('merchant_bussiness_category_pid');
            $merchant->merchant_description = $request->input('merchant_description');
            $merchant->merchant_tags = $request->input('merchant_tags');
            $merchant->data_sort = $request->input('data_sort') ?: 1000;
            $merchant->isactive = $request->input('isactive') ?: true;
            $merchant->isdelete = $request->input('isdelete') ?: false;
            $merchant->last_updated_by_user_name = $this->loginUsername();
            $merchant->save();

            DB::commit();

            return $this->sendSuccess($merchant);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendBadRequest($e->getMessage());
        }
    }
}

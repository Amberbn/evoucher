<?php
namespace App\Repository;

use App\Merchant;
use DB;

/**
 *
 */
class MerchantRepository
{
    use \App\Http\Controllers\Contract\UserTrait;

    public function getAllMerchants()
    {
        $merchants = DB::table('mch_merchant as mm')
            ->join('bsn_client as bc', 'mm.merchant_client_id', '=', 'bc.client_id')
            ->join('frm_global_parameters as bcat', 'mm.merchant_bussiness_category_pid', '=', 'bcat.parameters_id')
            ->where('mm.isactive', '=', true);
        if (!$this->isGroupSprint()) {
            $merchants->where('bc.client_category_pid', '=', $this->me()['client->client_category_pid']);
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

        return $merchants;
    }

    public function saveMerchant($request)
    {
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

        return $merchant;
    }

    public function getMerchantById($merchantId)
    {
        $merchant = Merchant::find($merchantId);

        return $merchant;
    }

    public function updateMerchant($request, $merchant)
    {
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

        return $merchant;
    }
}

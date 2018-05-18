<?php
namespace App\Repository;

use App\Merchant;
use DB;

/**
 *
 */
class MerchantRepository
{
    public function getAllMerchants()
    {
        $merchants = DB::table('mch_merchant as mm')
            ->join('bsn_client as bc', 'mm.client_id', '=', 'bc.client_id')
            ->join('frm_global_parameters as bcat', 'mm.merchant_bussiness_category_pid', '=', 'bcat.parameters_id')
            ->where('mm.isactive', '=', true)
            ->select(
                'mm.merchant_id',
                'mm.merchant_code',
                'mm.client_id',
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
                'mm.create_by_user_name',
                'mm.updated_at',
                'mm.last_update_by_user_name'
            )
            ->get();
        
        return $merchants;
    }

    public function saveMerchant($request, $createdBy)
    {
        $merchant = new Merchant;
        $merchant->merchant_code = $request->input('merchant_code');
        $merchant->client_id = $request->input('client_id');
        $merchant->merchant_title = $request->input('merchant_title');
        $merchant->merchant_bussiness_category_pid = $request->input('merchant_bussiness_category_pid');
        $merchant->merchant_description = $request->input('merchant_description');
        $merchant->merchant_tags = $request->input('merchant_tags');
        $merchant->data_sort = $request->input('data_sort') ? : 1000;
        $merchant->isactive = $request->input('isactive') ? : true;
        $merchant->isdelete = $request->input('isdelete') ? : false;
        // $merchant->create_by_user_name = $request->input('create_by_user_name');
        // $merchant->user_password_force_reset_on_login = $request->input('user_password_force_reset_on_login');
        // $merchant->user_password_is_intial = $request->input('user_password_is_intial');
        $merchant->create_by_user_name = $createdBy;
        $merchant->last_update_by_user_name = $createdBy;
        $merchant->save();

        return $merchant;
    }

    public function getMerchantById($merchantId)
    {
        $merchant = Merchant::find($merchantId);

        return $merchant;
    }

    public function updateMerchant($request, $merchant, $updateBy)
    {
        $merchant->merchant_code = $request->input('merchant_code');
        $merchant->client_id = $request->input('client_id');
        $merchant->merchant_title = $request->input('merchant_title');
        $merchant->merchant_bussiness_category_pid = $request->input('merchant_bussiness_category_pid');
        $merchant->merchant_description = $request->input('merchant_description');
        $merchant->merchant_tags = $request->input('merchant_tags');
        $merchant->data_sort = $request->input('data_sort') ? : 1000;
        $merchant->isactive = $request->input('isactive') ? : true;
        $merchant->isdelete = $request->input('isdelete') ? : false;
        // $merchant->create_by_user_name = $request->input('create_by_user_name');
        // $merchant->user_password_force_reset_on_login = $request->input('user_password_force_reset_on_login');
        // $merchant->user_password_is_intial = $request->input('user_password_is_intial');
        // $merchant->create_by_user_name = $createdBy;
        $merchant->last_update_by_user_name = $updateBy;
        $merchant->save();

        return $merchant;
    }
}

<?php
namespace App\Repository;

use App\Merchant;
use DB;

/**
 *
 */
class MerchantRepository
{
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
        $merchant->create_by_user_name = $request->input('create_by_user_name');
        $merchant->user_password_force_reset_on_login = $request->input('user_password_force_reset_on_login');
        $merchant->user_password_is_intial = $request->input('user_password_is_intial');
        $merchant->created_by_user_name = $createdBy;
        $merchant->last_updated_by_user_name = $createdBy;
        $merchant->save();
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
        $merchant->create_by_user_name = $request->input('create_by_user_name');
        $merchant->user_password_force_reset_on_login = $request->input('user_password_force_reset_on_login');
        $merchant->user_password_is_intial = $request->input('user_password_is_intial');
        $merchant->last_updated_by_user_name = $updateBy;
        $merchant->save();
    }
}

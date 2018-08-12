<?php

namespace App\Repository;

use App\Redeem;
use App\Repository\BaseRepository;
use DB;
use Carbon\Carbon;

class RedeemRepository extends BaseRepository
{
    public function redeem($request)
    {
        //variabel yang dilempar ke api redeem
        $voucherNumber = $request->input('voucher_number');
        $outletAuthentificationCode = $request->input('outlet_authentification_code');
        $referenceId = $request->input('reference_id');

        //variabel validasi
         $redeemFailureCode = "";
         $getDate = Carbon::now();

        $checkVoucher = DB::table('vw_redeem_check_voucher as ck')
            ->where('ck.voucher_generated_no', $voucherNumber)
            ->select(
                'ck.campaign_voucher_id',
                'ck.voucher_generated_id',
                'ck.voucher_generated_no',
                'ck.campaign_status',
                'ck.campaign_period_start_date',
                'ck.campaign_period_end_date',
                'ck.campaign_voucher_valid_start_date',
                'ck.campaign_voucher_valid_end_date',
                'ck.voucher_generated_is_redeemed',
                'ck.voucher_generated_locked_till',
                'ck.voucher_generated_fail_counter'
            )->get();

        //load data voucher
        $loadVoucher = DB::table('vw_redeem_check_outlet as co')
            ->where('co.campaign_voucher_id', $checkVoucher->campaign_voucher_id)
            ->where('co.outlets_auth_code', $outletAuthentificationCode)
            ->select(
                'co.outlets_id',
                'co.merchant_id'
            )->get();

        if ($checkVoucher->voucher_generated_id == null) {
            $redeemFailureCode = "INV";
        }
        if ($checkVoucher->voucher_generated_locked_till != null && $checkVoucher->voucher_generated_locked_till > $getDate) {
            
        }
        if ($checkVoucher->voucher_generated_is_redeemed == 1) {
             $redeemFailureCode = "RF01";
        }elseif ($getDate < $checkVoucher->campaign_voucher_valid_start_date || $getDate < $checkVoucher->campaign_period_start_date) {
            $redeemFailureCode = "RF02";
        }elseif ($getDate > $checkVoucher->campaign_voucher_valid_end_date || $getDate > $checkVoucher->campaign_period_end_date) {
            $redeemFailureCode = "RF03";
        }
        if ($loadVoucher->outlets_id == null) {
            $redeemFailureCode = "RF04";
        }

        if (($checkVoucher->voucher_generated_locked_till != null && $checkVoucher->voucher_generated_locked_till > $getDate) || $checkVoucher->voucher_generated_id == null) {
            $checkVoucher->voucher_generated_no;
            $getDate();
            $reference_id;
            $redeemFailureCode;
        }
        if ($redeemFailureCode != null) {
            

            if ($checkVoucher->voucher_generated_fail_counter == 4) {
                
            }elseif ($checkVoucher->voucher_generated_fail_counter <= 3) {
                
            }else{
                if ($redeemFailureCode == null) {
                    
                }
            }
        }
    }

    public function redeemInformation($voucherGeneratedNumber)
    {
        $redeemPage = [];

        $voucher = DB::table('vou_voucher_generated as vg')
            ->where('vg.voucher_generated_no', $voucherGeneratedNumber)
            ->select(
                'vg.campaign_id',
                'vg.campaign_voucher_id',
                'vg.voucher_generated_is_redeemed'
            )->first();


        if(!$voucher){
            return $this->sendNotfound();
        }

        $redeemInformation = DB::table('vw_redeem_landing_page as rlp')
                ->where('rlp.campaign_id', $voucher->campaign_id)
                ->where('rlp.campaign_voucher_id', $voucher->campaign_voucher_id)
                ->first();

        if(!$redeemInformation){
            return $this->sendNotfound();
        }

        $redeemPage['redeemInformation'] = $redeemInformation;

        $redeemTC = DB::table('vw_redeem_landing_page_outlets as vrco')
            ->where('vrco.campaign_id', $voucher->campaign_id)
            ->where('vrco.campaign_voucher_id', $voucher->campaign_voucher_id)
            ->get();

        if (!$redeemTC) {
           return $this->sendNotfound();
        }

         $redeemPage['redeemTC'] = $redeemTC;


         return $this->sendSuccess($redeemPage);

    }
}

<?php

namespace App\Repository;

use App\Redeem;
use App\Repository\BaseRepository;
use DB;
use Carbon\Carbon;

class RedeemRepository extends BaseRepository
{
    public function redeem($request, $voucherNumber)
    {
        // dd($voucherNumber);
        if (!$voucherNumber) {
           return $this->sendNotfound();
        }

        //variabel yang dilempar ke api redeem
        $outletAuthentificationCode = $request->input('outlet_authentification_code');
        $referenceId = $request->input('reference_id');


        // $redeem = DB::select(DB::raw("exec sp_campaign_voucher_redeem :voucher_number, :outlet_authentification_code, :reference_id"),[
        //     ':voucher_number' => $voucherNumber,
        //     ':outlet_authentification_code' => $outletAuthentificationCode,
        //     ':reference_id' => $referenceId
        // ]);
        DB::statement('SET NOCOUNT ON;');

        $redeem = DB::select("SET ANSI_NULLS ON; SET ANSI_WARNINGS ON; exec sp_campaign_voucher_redeem :voucher_number, :outlet_authentification_code, :reference_id",[
            ':voucher_number' => $voucherNumber,
            ':outlet_authentification_code' => $outletAuthentificationCode,
            ':reference_id' => $referenceId
        ]);

        return $this->sendSuccess($redeem);

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

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherCatalogOutlet extends Model
{
    protected $table = 'vou_voucher_catalog_outlets';
    protected $primaryKey = 'voucher_catalog_outets_id';
    public $timestamps = false;

    protected $fillable = [
        'voucher_catalog_id',
        'outlets_id',
        'merchant_id',
        'created_by_user_name',
    ];
}

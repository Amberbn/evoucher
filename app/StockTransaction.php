<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $table = "vou_stock_transaction";
    protected $primaryKey = "stock_transaction_id";
    public $timestamps = false;

    protected $fillable = [
        'voucher_catalog_id',
        'stock_transaction_adjustment_type',
        'campaign_id',
        'stock_transaction_adjustment_value',
        'stock_transaction_initial_stock_level',
        'stock_transaction_adjusted_stock_level',
        'created_by_user_name',
    ];
}

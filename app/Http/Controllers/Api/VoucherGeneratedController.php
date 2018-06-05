<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Repository\VoucherGeneratedRepository;

class VoucherGeneratedController extends ApiController
{
    public function __construct()
    {
        $this->repository = new VoucherGeneratedRepository;
    }
    public function generatedVoucher($campaignId)
    {
        return $this->repository->getVoucherGenerated($campaignId);
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Repository\GeneralSettingRepository;

class GeneralSettingController extends BaseControllerWeb
{
    public function __construct()
    {
        $this->repository = new GeneralSettingRepository;
    }

    public function index($parameterType, $parentId = null)
    {
        $response = $this->repository->getSetting($parameterType, $parentId);
        return $response->getData()->data;
    }
}

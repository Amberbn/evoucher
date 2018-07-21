<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\GeneralSettingRepository;

class GeneralSetting extends Controller
{
    public function __construct()
    {
        $this->repository = new GeneralSettingRepository;
    }
    public function getSetting($parameterType)
    {
        return $this->repository->getSetting($parameterType);
    }

    public function getAllSettings()
    {
        return $this->repository->getAllSettings();
    }
}

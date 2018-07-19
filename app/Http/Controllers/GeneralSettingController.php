<?php

namespace App\Http\Controllers;

use App\Repository\GeneralSettingRepository;

class GeneralSettingController extends Controller
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

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repository\GeneralSettingRepository;
use Illuminate\Support\Collection;

class BaseControllerWeb extends Controller
{
    public function getSettings($filters = null, $notIn = false)
    {
        return (new GeneralSettingRepository)
            ->getAllSettings($filters, $notIn)
            ->getData()->data;
    }

    public function getConfig($filters)
    {
        return (new GeneralSettingRepository)
            ->getConfig($filters)
            ->getData()->data;
    }

    public function getDataFromJson($response)
    {
        $data = new Collection($response->getData()->data);
        return $data;
    }

    public function getResponseCodeFromJson($response)
    {
        $data = new Collection($response->getData()->status_code);
        return $data->first();
    }

    public function pageNotFound()
    {
        return abort(404);

    }
}

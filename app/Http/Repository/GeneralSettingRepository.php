<?php
namespace App\Repository;

use App\GlobalParameter;
use App\Repository\BaseRepository;

class GeneralSettingRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new GlobalParameter;
    }

    public function getSetting($parameterType)
    {
        $settings = $this->model::where('parameters_type', $parameterType)
            ->select([
                'parameters_id',
                'parameters_value',
                'parameters_type',
            ])
            ->where('isactive', true)
            ->where('isdelete', false)
            ->get();
        if (empty($settings->toArray())) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($settings);
    }
}

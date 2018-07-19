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

    public function getSetting($parameterType, $parentId = null)
    {
        $settings = $this->model::where('parameters_type', $parameterType);
        if ((int) $parentId > 0) {
            $settings->where('parameters_parent_id', $parentId);
        }
        $settings->where('isactive', true);
        $settings->where('isdelete', false);
        $settings->select([
            'parameters_id',
            'parameters_value',
            'parameters_type',
        ]);
        $result = $settings->get();
        if (empty($result->toArray())) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($result);
    }
}

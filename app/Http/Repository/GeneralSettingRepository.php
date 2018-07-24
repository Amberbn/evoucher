<?php
namespace App\Repository;

use App\Config;
use App\GlobalParameter;
use App\Repository\BaseRepository;

class GeneralSettingRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new GlobalParameter;
        $this->config = new Config;
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

    public function getAllSettings($param = null, $filterByNotIn = false)
    {
        $settings = $this->model::select('parameters_type');
        if ($param && !$filterByNotIn) {
            $settings = $settings->whereIn('parameters_type', $param);
        } else if ($param && $filterByNotIn) {
            $settings = $settings->whereNotIn('parameters_type', $param);
        }
        $settings = $settings->distinct('parameters_type');
        $settings = $settings->get()->toArray();

        $arrayData = [];
        foreach ($settings as $setting) {
            $data = $this->getSetting($setting['parameters_type']);
            $arrayData[camel_case($setting['parameters_type'])] = $data->getData()->data;
        }

        if (empty($arrayData)) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($arrayData);
    }

    public function getConfig($param)
    {
        $config = $this->config::select([
            'config_name',
            'config_group_name',
            'config_value',
        ]);
        $config = $config->where('config_name', $param);
        $config = $config->first();

        if (empty($config->toArray())) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($config);
    }
}

<?php
namespace App\Http\Repository;

use App\Outlet;

class OutletRepository
{
    public function __construct()
    {
        $this->model = new Outlet;
    }

    public function getOutlet($outletId = null)
    {
        $table = $this->model->getTable();
        $outlet = $this->model
            ->join('frm_global_parameters as province', function ($join) use ($table) {
                $join
                    ->on('province.parameters_id', '=', $table . '.outlets_address_province_pid')
                    ->where('province.parameters_type', '=', 'address_state_province');
            })
            ->join('frm_global_parameters as city', function ($join) use ($table) {
                $join
                    ->on('city.parameters_id', '=', $table . '.outlets_address_city_pid')
                    ->where('city.parameters_type', '=', 'address_city');
            })
            ->join('frm_global_parameters as region', function ($join) use ($table) {
                $join
                    ->on('region.parameters_id', '=', $table . '.client_billing_address_region_pid')
                    ->where('region.parameters_type', '=', 'address_region');
            });

        if ($outletId) {
            $outlet->where($table . '.outlets_id', '=', $outletId);
        }
        $outlet->where($table . '.isactive', '=', true);
        $outlet->select(
            $table . '.outlets_code',
            $table . '.merchant_id',
            $table . '.client_id',
            $table . '.outlets_title',
            $table . '.outlets_email',
            $table . '.outlets_phone',
            $table . '.outlets_description',
            $table . '.outlets_address_line',
            $table . '.outlets_address_province_pid',
            $table . '.outlets_address_city_pid',
            $table . '.client_billing_address_region_pid',
            $table . '.outlets_location_coordinates',
            $table . '.outlets_auth_code',
            $table . '.data_sort',
            $table . '.isactive',
            $table . '.isdelete',
            $table . '.created_at',
            $table . '.created_by_user_name',
            $table . '.updated_at',
            $table . '.last_updated_by_user_name',
            'province.parameters_value as outlets_address_province_title',
            'city.parameters_value as outlets_address_city_title',
            'region.parameters_value as client_billing_address_region_title'
        );

        return $outlet;

    }

    public function store($request, $creatBy)
    {
        $outlet = $this->model;
        $outlet->outlets_code = $request->input('outlets_code');
        $outlet->merchant_id = $request->input('merchant_id');
        $outlet->client_id = $request->input('client_id');
        $outlet->outlets_title = $request->input('outlets_title');
        $outlet->outlets_email = $request->input('outlets_email');
        $outlet->outlets_phone = $request->input('outlets_phone');
        $outlet->outlets_description = $request->input('outlets_description');
        $outlet->outlets_address_line = $request->input('outlets_address_line');
        $outlet->outlets_address_province_pid = $request->input('outlets_address_province_pid');
        $outlet->outlets_address_city_pid = $request->input('outlets_address_city_pid');
        $outlet->client_billing_address_region_pid = $request->input('client_billing_address_region_pid');
        $outlet->outlets_location_coordinates = $request->input('outlets_location_coordinates');
        $outlet->outlets_auth_code = $request->input('outlets_auth_code');
        $outlet->data_sort = $request->input('data_sort') ?: 1000;
        $outlet->isactive = $request->input('isactive') ?: true;
        $outlet->isdelete = $request->input('isdelete') ?: false;
        $outlet->created_by_user_name = $creatBy;
        $outlet->save();

        return $outlet;
    }

    public function update($request, $outlet, $updateBy)
    {
        $outlet->merchant_id = $request->input('merchant_id');
        $outlet->client_id = $request->input('client_id');
        $outlet->outlets_title = $request->input('outlets_title');
        $outlet->outlets_email = $request->input('outlets_email');
        $outlet->outlets_phone = $request->input('outlets_phone');
        $outlet->outlets_description = $request->input('outlets_description');
        $outlet->outlets_address_line = $request->input('outlets_address_line');
        $outlet->outlets_address_province_pid = $request->input('outlets_address_province_pid');
        $outlet->outlets_address_city_pid = $request->input('outlets_address_city_pid');
        $outlet->client_billing_address_region_pid = $request->input('client_billing_address_region_pid');
        $outlet->outlets_location_coordinates = $request->input('outlets_location_coordinates');
        $outlet->outlets_auth_code = $request->input('outlets_auth_code');
        $outlet->data_sort = $request->input('data_sort') ?: 1000;
        $outlet->isactive = $request->input('isactive') ?: true;
        $outlet->isdelete = $request->input('isdelete') ?: false;
        $outlet->last_updated_by_user_name = $updateBy;
        $outlet->save();

        return $outlet;
    }

    public function delete($outlet, $updateBy)
    {
        $outlet->isdelete = true;
        $outlet->last_updated_by_user_name = $updateBy;
        $outlet->save();

        return $outlet;
    }
}

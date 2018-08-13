<?php
namespace App\Http\Repository;

use App\Outlet;
use App\Merchant;
use App\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;

class OutletRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Outlet;
    }

    public function outletFilter()
    {
        return [
            'orderBy' => 'outlets_code',
            'filter_1' => 'outlets_code',
            'filter_2' => 'outlets_title',
            'filter_3' => 'merchant_code',
        ];
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
                    ->on('region.parameters_id', '=', $table . '.outlets_address_region_pid')
                    ->where('region.parameters_type', '=', 'address_region');
            })
            ->join('bsn_client as client', function ($join) use ($table) {
                $join
                    ->on('client.client_id', '=', $table . '.merchant_client_id');
            })
            ->join('mch_merchant as merchant', function ($join) use ($table) {
                $join
                    ->on('merchant.merchant_id', '=', $table . '.merchant_id');
            });

        if ($outletId) {
            $outlet->where($table . '.outlets_id', '=', $outletId);
        }

        if (!$this->isGroupSprint()) {
            $outlet->where('client.client_category_pid', '=', $this->me()['client_category_pid']);
        }

        $outlet->where($table . '.isactive', '=', true);
        $outlet->where($table . '.isdelete', '=', false);

        $outlet->select(
            $table . '.outlets_code',
            $table . '.merchant_id',
            $table . '.merchant_client_id',
            $table . '.outlets_title',
            $table . '.outlets_email',
            $table . '.outlets_phone',
            $table . '.outlets_description',
            $table . '.outlets_address_line',
            $table . '.outlets_address_province_pid',
            $table . '.outlets_address_city_pid',
            $table . '.outlets_address_region_pid',
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
            'region.parameters_value as outlets_address_region_title',
            'client.client_code',
            'client.client_name',
            'merchant.merchant_code',
            'merchant.merchant_title'
        );

        if (empty($outlet->get()->toArray())) {
            return $this->sendNotfound();
        }
        $filter = $this->outletFilter();

        if ($outletId) {
            return $this->sendSuccess($outlet->get()->toArray());
        }

        return $this->dataTableResponseBuilder($outlet, $filter);

    }

    public function getOutletByMercahantId($merchantId)
    {
        $outlet = $this->model::join('mch_merchant as merchant', 'mch_outlets.merchant_id','=', 'merchant.merchant_id')
        ->select(
            [
                'mch_outlets.outlets_id',
                'mch_outlets.outlets_title'
            ]
        )->where('mch_outlets.merchant_id',$merchantId)
            ->where('mch_outlets.isactive',true)
            ->where('mch_outlets.isdelete',false)->get();

        if (empty($outlet->toArray())) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($outlet);
    }

    public function store($request, $merchantId)
    {
        try {
            DB::beginTransaction();

            $outlet = $this->model;
            $outlet->merchant_id = $merchantId;
            $outlet->outlets_code = $request->input('outlets_code');
            
            $outlet->merchant_client_id = $request->input('merchant_client_id');
            $outlet->outlets_title = $request->input('outlets_title');
            $outlet->outlets_email = $request->input('outlets_email');
            $outlet->outlets_phone = $request->input('outlets_phone');
            $outlet->outlets_description = $request->input('outlets_description');
            $outlet->outlets_address_line = $request->input('outlets_address_line');
            $outlet->outlets_address_province_pid = $request->input('outlets_address_province_pid');
            $outlet->outlets_address_city_pid = $request->input('outlets_address_city_pid');
            $outlet->outlets_address_region_pid = $request->input('outlets_address_region_pid');
            $outlet->outlets_location_coordinates = $request->input('outlets_location_coordinates');
            $outlet->outlets_auth_code = $request->input('outlets_auth_code');
            $outlet->data_sort = $request->input('data_sort') ?: 1000;
            $outlet->isactive = $request->input('isactive') ?: true;
            $outlet->isdelete = $request->input('isdelete') ?: false;
            $outlet->created_by_user_name = $this->loginUsername();
            $outlet->save();

            DB::commit();

            return $this->sendCreated($outlet);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }

        return $outlet;
    }

    public function update($request, $outletId)
    {
        $outlet = $this->model::where('outlets_id', $outletId)->first();
        if (!$outlet) {
            return $this->sendNotfound();
        }

        try {
            DB::beginTransaction();

            $outlet->merchant_id = $request->input('merchant_id');
            $outlet->merchant_client_id = $request->input('merchant_client_id');
            $outlet->outlets_title = $request->input('outlets_title');
            $outlet->outlets_email = $request->input('outlets_email');
            $outlet->outlets_phone = $request->input('outlets_phone');
            $outlet->outlets_description = $request->input('outlets_description');
            $outlet->outlets_address_line = $request->input('outlets_address_line');
            $outlet->outlets_address_province_pid = $request->input('outlets_address_province_pid');
            $outlet->outlets_address_city_pid = $request->input('outlets_address_city_pid');
            $outlet->outlets_address_region_pid = $request->input('outlets_address_region_pid');
            $outlet->outlets_location_coordinates = $request->input('outlets_location_coordinates');
            $outlet->outlets_auth_code = $request->input('outlets_auth_code');
            $outlet->data_sort = $request->input('data_sort') ?: 1000;
            $outlet->isactive = $request->input('isactive') ?: true;
            $outlet->isdelete = $request->input('isdelete') ?: false;
            $outlet->last_updated_by_user_name = $this->loginUsername();
            $outlet->save();

            DB::commit();

            return $this->sendSuccess($outlet);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
    }

    public function delete($outletId)
    {
        $outlet = $this->model::where('outlets_id', $outletId)->first();

        if (!$outlet) {
            return $this->sendNotfound();
        }

        try {
            DB::beginTransaction();

            $outlet->isdelete = true;
            $outlet->last_updated_by_user_name = $this->loginUsername();
            $outlet->save();

            DB::commit();
            return $this->sendSuccess($outlet);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->throwErrorException($e);
        }
    }
}

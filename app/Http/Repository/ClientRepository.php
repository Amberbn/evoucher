<?php
namespace App\Repository;

use App\Client;
use App\Repository\BaseRepository;

class ClientRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Client;
    }

    public function getClient($clientId = null)
    {
        $table = $this->model->getTable();
        $client = $this->model
            ->join('frm_global_parameters as clcat', function ($join) use ($table) {
                $join
                    ->on('clcat.parameters_id', '=', $table . '.client_category_pid')
                    ->where('clcat.parameters_type', '=', 'client_category');
            })
            ->join('frm_global_parameters as city', function ($join) use ($table) {
                $join
                    ->on('city.parameters_id', '=', $table . '.client_billing_address_city_pid')
                    ->where('city.parameters_type', '=', 'address_city');
            })
            ->join('frm_global_parameters as ind', function ($join) use ($table) {
                $join
                    ->on('ind.parameters_id', '=', $table . '.client_industry_category_pid')
                    ->where('ind.parameters_type', '=', 'industry_category');
            })
            ->join('frm_global_parameters as emp', function ($join) use ($table) {
                $join
                    ->on('emp.parameters_id', '=', $table . '.client_employee_size_category_pid')
                    ->where('emp.parameters_type', '=', 'employee_size_category');
            });

        if ($clientId) {
            $client->where($table . '.client_id', '=', $clientId);
        }

        if (!$this->isGroupSprint()) {
            $client->where($table . '.client_category_pid', '=', $this->me()['client_category_pid']);
        }

        $client->where($table . '.isactive', '=', true);
        $client->where($table . '.isdelete', '=', false);

        $client->select(
            $table . '.client_code',
            $table . '.client_category_pid',
            $table . '.client_is_also_merchant',
            $table . '.client_allow_postpaid',
            $table . '.client_name',
            $table . '.client_legal_name',
            $table . '.client_tax_no',
            $table . '.client_billing_address_line_1',
            $table . '.client_billing_address_line_2',
            $table . '.client_billing_address_state_province_pid',
            $table . '.client_billing_address_city_pid',
            $table . '.client_billing_address_postal_code',
            $table . '.client_industry_category_pid',
            $table . '.client_employee_size_category_pid',
            $table . '.client_outstanding_limit',
            $table . '.isactive',
            $table . '.isdelete',
            $table . '.created_at',
            $table . '.created_by_user_name',
            $table . '.updated_at',
            $table . '.last_updated_by_user_name',
            'clcat.parameters_value as client_category_title',
            'ind.parameters_value as industry_category_title',
            'emp.parameters_value as employee_size_category_title',
            'city.parameters_value as client_billing_address_city_title'
        );

        return $client;
    }
    public function store($request)
    {
        $client = new Client;
        $client->client_code = $request->input('client_code');
        $client->client_category_pid = $request->input('client_category_pid');
        $client->client_is_also_merchant = $request->input('client_is_also_merchant');
        $client->client_allow_postpaid = $request->input('client_allow_postpaid');
        $client->client_name = $request->input('client_name');
        $client->client_legal_name = $request->input('client_legal_name');
        $client->client_tax_no = $request->input('client_tax_no');
        $client->client_billing_address_line_1 = $request->input('client_billing_address_line_1');
        $client->client_billing_address_line_2 = $request->input('client_billing_address_line_2');
        $client->client_billing_address_region_pid = $request->input('client_billing_address_region_pid');
        $client->client_billing_address_state_province_pid = $request->input('client_billing_address_state_province_pid');
        $client->client_billing_address_city_pid = $request->input('client_billing_address_city_pid');
        $client->client_billing_address_postal_code = $request->input('client_billing_address_postal_code');
        $client->client_industry_category_pid = $request->input('client_industry_category_pid');
        $client->client_employee_size_category_pid = $request->input('client_employee_size_category_pid');
        $client->client_outstanding_limit = $request->input('client_outstanding_limit');
        $client->isactive = $request->input('isactive') ?: true;
        $client->isdelete = $request->input('isdelete') ?: false;
        $client->created_by_user_name = $this->loginUsername();
        $client->last_updated_by_user_name = $this->loginUsername();
        $client->save();

        return $client;
    }

    public function update($request, $client)
    {
        $client->client_category_pid = $request->input('client_category_pid');
        $client->client_is_also_merchant = $request->input('client_is_also_merchant');
        $client->client_allow_postpaid = $request->input('client_allow_postpaid');
        $client->client_name = $request->input('client_name');
        $client->client_legal_name = $request->input('client_legal_name');
        $client->client_tax_no = $request->input('client_tax_no');
        $client->client_billing_address_line_1 = $request->input('client_billing_address_line_1');
        $client->client_billing_address_line_2 = $request->input('client_billing_address_line_2');
        $client->client_billing_address_region_pid = $request->input('client_billing_address_region_pid');
        $client->client_billing_address_state_province_pid = $request->input('client_billing_address_state_province_pid');
        $client->client_billing_address_city_pid = $request->input('client_billing_address_city_pid');
        $client->client_billing_address_postal_code = $request->input('client_billing_address_postal_code');
        $client->client_industry_category_pid = $request->input('client_industry_category_pid');
        $client->client_employee_size_category_pid = $request->input('client_employee_size_category_pid');
        $client->client_outstanding_limit = $request->input('client_outstanding_limit');
        $client->isactive = $request->input('isactive');
        $client->isdelete = $request->input('isdelete');
        $client->last_updated_by_user_name = $this->loginUsername();
        $client->save();

        return $client;
    }

    public function delete($client)
    {
        $client->isdelete = true;
        $client->last_updated_by_user_name = $this->loginUsername();
        $client->save();

        return $client;
    }
}

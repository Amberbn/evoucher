<?php
namespace App\Repository;

use App\Client;

class ClientRepository
{

    public function getClient($clientId = null)
    {
        $table = (new Client)->getTable();
        $client = (new Client)
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

        $client->where($table . '.isactive', '=', true);
        $client->select(
            $table . '.client_code',
            $table . '.client_category_pid',
            'clcat.parameters_value as client_category_title',
            $table . '.client_is_also_merchant',
            $table . '.client_allow_postpaid',
            $table . '.client_name',
            $table . '.client_tax_no',
            $table . '.client_billing_address_line_1',
            $table . '.client_billing_address_line_2',
            $table . '.client_billing_address_state_province_pid',
            $table . '.client_billing_address_city_pid',
            $table . '.client_billing_address_postal_code',
            $table . '.client_industry_category_pid',
            'ind.parameters_value as industry_category_title',
            $table . '.client_employee_size_category_pid',
            'emp.parameters_value as employee_size_category_title',
            'city.parameters_value as client_billing_address_city_title',
            $table . '.client_outstanding_limit',
            $table . '.isactive',
            $table . '.isdelete',
            $table . '.created_at',
            $table . '.created_by_user_name',
            $table . '.updated_at',
            $table . '.last_updated_by_user_name'
        );

        return $client;
    }
    public function store($request, $createdBy)
    {
        $client = new Client;
        $client->client_code = $request->client_code;
        $client->client_category_pid = $request->client_category_pid;
        $client->client_is_also_merchant = $request->client_is_also_merchant;
        $client->client_allow_postpaid = $request->client_allow_postpaid;
        $client->client_name = $request->client_name;
        $client->client_tax_no = $request->client_tax_no;
        $client->client_billing_address_line_1 = $request->client_billing_address_line_1;
        $client->client_billing_address_line_2 = $request->client_billing_address_line_2;
        $client->client_billing_address_state_province_pid = $request->client_billing_address_state_province_pid;
        $client->client_billing_address_city_pid = $request->client_billing_address_city_pid;
        $client->client_billing_address_postal_code = $request->client_billing_address_postal_code;
        $client->client_industry_category_pid = $request->client_industry_category_pid;
        $client->client_employee_size_category_pid = $request->client_employee_size_category_pid;
        $client->client_outstanding_limit = $request->client_outstanding_limit;
        $client->isactive = $request->isactive;
        $client->isdelete = $request->isdelete;
        $client->created_by_user_name = $createdBy;
        $client->last_updated_by_user_name = $createdBy;
        $client->save();

        return $client;
    }

    public function update($request, $client, $updateBy)
    {
        $client->client_category_pid = $request->client_category_pid;
        $client->client_is_also_merchant = $request->client_is_also_merchant;
        $client->client_allow_postpaid = $request->client_allow_postpaid;
        $client->client_name = $request->client_name;
        $client->client_tax_no = $request->client_tax_no;
        $client->client_billing_address_line_1 = $request->client_billing_address_line_1;
        $client->client_billing_address_line_2 = $request->client_billing_address_line_2;
        $client->client_billing_address_state_province_pid = $request->client_billing_address_state_province_pid;
        $client->client_billing_address_city_pid = $request->client_billing_address_city_pid;
        $client->client_billing_address_postal_code = $request->client_billing_address_postal_code;
        $client->client_industry_category_pid = $request->client_industry_category_pid;
        $client->client_employee_size_category_pid = $request->client_employee_size_category_pid;
        $client->client_outstanding_limit = $request->client_outstanding_limit;
        $client->isactive = $request->isactive;
        $client->isdelete = $request->isdelete;
        $client->last_updated_by_user_name = $updateBy;
        $client->save();

        return $client;
    }

    public function delete($client, $updateBy)
    {
        $client->isdelete = true;
        $client->last_updated_by_user_name = $updateBy;
        $client->save();

        return $client;
    }
}

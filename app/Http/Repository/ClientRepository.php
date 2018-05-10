<?php
namespace App\Repository;
use App\Client; 

class ClientRepository 
{
    
    public function store($request,$createdBy)
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

    public function update($request,$client,$updateBy)
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

    public function delete($client,$updateBy)
    {
        $client->isdelete = true;
        $client->last_updated_by_user_name = $updateBy;
        $client->save();

        return $client;
    }
}
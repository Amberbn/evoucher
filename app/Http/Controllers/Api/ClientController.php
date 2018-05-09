<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Client;
use DB;

class ClientController extends ApiController
{
    public function getClients()
    {
        $client = Client::active()->get();
        if(!$client) {
            return $this->sendNotfound();
        }
        
        return $this->sendSuccess($client);
    }

    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            $validate = $this->validateStoreClient($request);
            if ($validate->fails()) {
                return $this->sendValidationError($validate->errors()->toArray());
            }

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
            $client->created_by_user_name = $request->created_by_user_name;
            $client->last_updated_by_user_name = $request->last_updated_by_user_name;
            $client->save();
            
            DB::commit();

            return $this->sendCreated($client);

        } catch(\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function getClient($clientid)
    {
        $client = Client::active()->where('client_code',$clientid)->first();
        if(!$client) {
             return $this->sendNotfound();
        }

        return $this->sendSuccess($client);
    }

    private function validateStoreClient(Request $request)
    {
        $rules = [
            'client_code' => 'required|unique:bsn_client,client_code|min:3',
            'client_category_pid' => 'required|numeric',
            'client_name' => 'required|min:3',
            'client_billing_address_line_1' => 'required|min:3',
            'client_billing_address_state_province_pid' => 'required|numeric',
            'client_billing_address_city_pid' => 'required|numeric',
            'client_billing_address_postal_code' => 'required|numeric',
            'client_industry_category_pid' => 'required|numeric',
            'client_employee_size_category_pid' => 'required|numeric',
        ];

        return Validator::make($request->all(), $rules);
    }

    public function update($clientId)
    {
        $client = Client::where('client_code',$clientid)->first();
        if(!$client) {
            return $this->sendNotfound();
        }

        $validate = $this->validateStoreClient($request);
        if ($validate->fails()) {
            return $this->sendValidationError($validate->errors()->toArray());
        }
        
        try{

            DB::beginTransaction();

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
            $client->created_by_user_name = $request->created_by_user_name;
            $client->last_updated_by_user_name = $request->last_updated_by_user_name;
            $client->save();
            
            DB::commit();

        } catch(\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }
}

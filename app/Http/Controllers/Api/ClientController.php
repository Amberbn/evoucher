<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Repository\ClientRepository;
use App\Http\Requests\StoreClient;
use App\Http\Requests\UpdateClient;
use App\Client;
use DB;

class ClientController extends ApiController
{
    public function __construct()
    {
        $this->model = new Client;
        $this->repository = new ClientRepository;
    }

    public function getClients()
    {
        $client = $this->model::active()->get();
        if(!$client) {
            return $this->sendNotfound();
        }
        return $this->sendSuccess($client);
    }

    public function store(StoreClient $request)
    {
        try {
            DB::beginTransaction();
            $createdBy = $this->createdOrUpdatedByUsername($request);
            $client = $this->repository->store($request,$createdBy);
            DB::commit();
            return $this->sendCreated($client);

        } catch(\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function getClient($clientid)
    {
        $client = $this->model::active()->where('client_code',$clientid)->first();
        if(!$client) {
             return $this->sendNotfound();
        }

        return $this->sendSuccess($client);
    }

    public function update(UpdateClient $request,$clientId)
    {
        $client = $this->model::where('client_code',$clientId)->first();

        if(!$client) {
            return $this->sendNotfound();
        }

        try{

            DB::beginTransaction();
            $updateBy = $this->createdOrUpdatedByUsername($request);
            $client = $this->repository->update($client,$updateBy);
            DB::commit();
            
            return $this->sendSuccess($client);

        } catch(\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function delete(Request $request,$clientId)
    {
        $client = $this->model::where('client_code',$clientId)->first();

        if(!$client) {
            return $this->sendNotfound();
        }

        try{
            
            DB::beginTransaction();
            $updateBy = $this->createdOrUpdatedByUsername($request);
            $client = $this->repository->delete($client,$updateBy);
            DB::commit();

            return $this->sendSuccess($client);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
        
    }
}

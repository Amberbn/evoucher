<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreClient;
use App\Http\Requests\UpdateClient;
use App\Repository\ClientRepository;
use DB;
use Illuminate\Http\Request;

class ClientController extends ApiController
{
    public function __construct()
    {
        $this->model = new Client;
        $this->repository = new ClientRepository;
    }

    public function getClients()
    {
        $client = $this->repository->getClient()->get()->toArray();
        if (empty($client)) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($client);
    }

    public function store(StoreClient $request)
    {
        try {
            DB::beginTransaction();
            $createdBy = $this->createdOrUpdatedByUsername($request);
            $client = $this->repository->store($request, $createdBy);
            DB::commit();
            return $this->sendCreated($client);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function getClient($clientId)
    {
        $client = $this->repository->getClient($clientId)->get()->toArray();
        if (empty($client)) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($client);
    }

    public function update(UpdateClient $request, $clientId)
    {
        $client = $this->model::where('client_id', $clientId)->first();

        if (!$client) {
            return $this->sendNotfound();
        }

        try {

            DB::beginTransaction();
            $updateBy = $this->createdOrUpdatedByUsername($request);
            $client = $this->repository->update($request, $client, $updateBy);
            DB::commit();

            return $this->sendSuccess($client);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    public function delete(Request $request, $clientId)
    {
        $client = $this->model::where('client_id', $clientId)->first();

        if (!$client) {
            return $this->sendNotfound();
        }

        try {

            DB::beginTransaction();
            $updateBy = $this->createdOrUpdatedByUsername($request);
            $client = $this->repository->delete($client, $updateBy);
            DB::commit();

            return $this->sendSuccess($client);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }

    }
}

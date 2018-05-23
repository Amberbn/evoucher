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
    /**
     *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
     */
    public function __construct()
    {
        $this->model = new Client;
        $this->repository = new ClientRepository;
    }

    /**
     *FUNCTION FOR SET FILTER CLIENT
     *@return Array $filter
     */
    public function clientFilter()
    {
        $filter = [
            'orderBy' => 'client_code',
            'filter_1' => 'client_code',
            'filter_2' => 'client_name',
            'filter_3' => 'client_legal_name',
        ];

        return $filter;

    }

    /**
     *FUNCTION FOR GET ALL DATA CLIENT
     *@return \Illuminate\Http\Response
     */
    public function getClients()
    {
        $client = $this->repository->getClient();

        if (empty($client->get()->toarray())) {
            return $this->sendNotfound();
        }
        $filter = $this->clientFilter();

        return $this->dataTableResponseBuilder($client, $filter);
    }

    /**
     *FUNCTION FOR STORE DATA CLIENT
     *@param StoreClient $request
     *@return \Illuminate\Http\Response
     */
    public function store(StoreClient $request)
    {
        try {
            DB::beginTransaction();
            $client = $this->repository->store($request);
            DB::commit();
            return $this->sendCreated($client);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    /**
     *FUNCTION FOR GET DETAIL CLIENT
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function getClient($clientId)
    {
        $client = $this->repository->getClient($clientId)->get()->toArray();
        if (empty($client)) {
            return $this->sendNotfound();
        }

        return $this->sendSuccess($client);
    }

    /**
     *FUNCTION FOR UPDATE CLIENT
     *@param UpdateClient $request
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function update(UpdateClient $request, $clientId)
    {
        $client = $this->model::where('client_id', $clientId)->first();

        if (!$client) {
            return $this->sendNotfound();
        }

        try {

            DB::beginTransaction();
            $client = $this->repository->update($request, $client);
            DB::commit();

            return $this->sendSuccess($client);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    /**
     *FUNCTION FOR DELETE CLIENT
     *@param Request $request
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function delete(Request $request, $clientId)
    {
        $client = $this->model::where('client_id', $clientId)->first();

        if (!$client) {
            return $this->sendNotfound();
        }

        try {

            DB::beginTransaction();
            $client = $this->repository->delete($client);
            DB::commit();

            return $this->sendSuccess($client);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }

    }
}

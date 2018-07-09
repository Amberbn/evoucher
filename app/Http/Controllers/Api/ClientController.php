<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreClient;
use App\Http\Requests\UpdateClient;
use App\Repository\ClientRepository;
use Illuminate\Http\Request;

class ClientController extends ApiController
{
    /**
     *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
     */
    public function __construct()
    {
        $this->repository = new ClientRepository;
    }

    /**
     *FUNCTION FOR GET ALL DATA CLIENT
     *@return \Illuminate\Http\Response
     */
    public function getClients()
    {
        return $this->repository->getClient();
    }

    /**
     *FUNCTION FOR STORE DATA CLIENT
     *@param StoreClient $request
     *@return \Illuminate\Http\Response
     */
    public function store(StoreClient $request)
    {
        return $this->repository->store($request);
    }

    /**
     *FUNCTION FOR GET DETAIL CLIENT
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function getClient($clientId)
    {
        return $this->repository->getClient($clientId);
    }

    /**
     *FUNCTION FOR UPDATE CLIENT
     *@param UpdateClient $request
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function update(UpdateClient $request, $clientId)
    {
        return $this->repository->update($request, $clientId);
    }

    /**
     *FUNCTION FOR DELETE CLIENT
     *@param Request $request
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function delete($clientId)
    {
        return $this->repository->delete($clientId);

    }
}

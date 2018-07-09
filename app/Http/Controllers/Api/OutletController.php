<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Repository\OutletRepository;
use App\Http\Requests\StoreOutlet;
use App\Http\Requests\UpdateOutlet;
use Illuminate\Http\Request;

class OutletController extends ApiController
{
    /**
     *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
     */
    public function __construct()
    {
        $this->repository = new OutletRepository;
    }

    /**
     *FUNCTION FOR GET ALL DATA OTLET
     *@return \Illuminate\Http\Response
     */
    public function outlets()
    {
        return $this->repository->getOutlet();
    }

    /**
     *FUNCTION FOR GET DETAIL OTLET
     *@param int $outletId
     *@return \Illuminate\Http\Response
     */
    public function outlet($outletId)
    {
        return $this->repository->getOutlet($outletId);
    }

    /**
     *FUNCTION FOR STORE DATA OTLET
     *@param StoreOutlet $request
     *@return \Illuminate\Http\Response
     */
    public function store(StoreOutlet $request)
    {
        return $this->repository->store($request);
    }

    /**
     *FUNCTION FOR UPDATE DATA CLIENT
     *@param UpdateOutlet $request
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function update(UpdateOutlet $request, $outletId)
    {
        return $this->repository->update($request, $outletId);
    }

    /**
     *FUNCTION FOR DELETE DATA CLIENT
     *@param Request $request
     *@param int $outletId
     *@return \Illuminate\Http\Response
     */
    public function delete(Request $request, $outletId)
    {
        return $this->repository->delete($outletId);
    }
}

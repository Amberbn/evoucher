<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Repository\OutletRepository;
use App\Http\Requests\StoreOutlet;
use App\Http\Requests\UpdateOutlet;
use App\Outlet;
use DB;
use Illuminate\Http\Request;

class OutletController extends ApiController
{
    /**
     *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
     */
    public function __construct()
    {
        $this->model = new Outlet;
        $this->repository = new OutletRepository;
    }

    /**
     *FUNCTION FOR GET ALL DATA OTLET
     *@return \Illuminate\Http\Response
     */
    public function outlets()
    {
        $outlet = $this->repository->getOutlet()->get()->toArray();
        if (empty($outlet)) {
            return $this->sendNotfound();
        }
        return $this->sendSuccess($outlet);
    }

    /**
     *FUNCTION FOR GET DETAIL OTLET
     *@param int $outletId
     *@return \Illuminate\Http\Response
     */
    public function outlet($outletId)
    {
        $outlet = $this->repository->getOutlet($outletId)->get()->toArray();
        if (empty($outlet)) {
            return $this->sendNotfound();
        }
        return $this->sendSuccess($outlet);
    }

    /**
     *FUNCTION FOR STORE DATA OTLET
     *@param StoreOutlet $request
     *@return \Illuminate\Http\Response
     */
    public function store(StoreOutlet $request)
    {
        try {
            DB::beginTransaction();
            $createdBy = $this->createdOrUpdatedByUsername($request);
            $outlet = $this->repository->store($request, $createdBy);
            DB::commit();
            return $this->sendCreated($outlet);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    /**
     *FUNCTION FOR UPDATE DATA CLIENT
     *@param UpdateOutlet $request
     *@param int $clientId
     *@return \Illuminate\Http\Response
     */
    public function update(UpdateOutlet $request, $outletId)
    {
        $outlet = $this->model::where('outlets_id', $outletId)->first();

        if (!$outlet) {
            return $this->sendNotfound();
        }

        try {

            DB::beginTransaction();
            $updateBy = $this->createdOrUpdatedByUsername($request);
            $outlet = $this->repository->update($request, $outlet, $updateBy);
            DB::commit();

            return $this->sendSuccess($outlet);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }
    }

    /**
     *FUNCTION FOR DELETE DATA CLIENT
     *@param Request $request
     *@param int $outletId
     *@return \Illuminate\Http\Response
     */
    public function delete(Request $request, $outletId)
    {
        $outlet = $this->model::where('outlets_id', $outletId)->first();

        if (!$outlet) {
            return $this->sendNotfound();
        }

        try {

            DB::beginTransaction();
            $updateBy = $this->createdOrUpdatedByUsername($request);
            $outlet = $this->repository->delete($outlet, $updateBy);
            DB::commit();

            return $this->sendSuccess($outlet);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendBadRequest($e->getMessage());
        }

    }
}

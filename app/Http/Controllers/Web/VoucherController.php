<?php

namespace App\Http\Controllers\Web;

use App\Http\Repository\OutletRepository;
use App\Http\Repository\VoucherCatalogRepository;
use App\Repository\MerchantRepository;
use Illuminate\Http\Request;

class VoucherController extends BaseControllerWeb
{
    public function __construct()
    {
        $this->repository = new VoucherCatalogRepository;
        $this->merchantRepository = new MerchantRepository;
        $this->outletRepository = new OutletRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = $this->repository->getVoucherCatalogTags();
        $tagsData = $this->getDataFromJson($tags);

        $voucherCategory = $this->getSettings(['voucher_category_pid']);
        return view('voucher.voucher_form', compact('tagsData', 'voucherCategory'));
    }

    public function saveVoucherProfile(Request $request)
    {
        $voucher = $this->repository->createVoucherProfile($request);
        $voucherProfile = $this->getDataFromJson($voucher);
        return redirect()->route('voucher.detail', ['id' => $voucherProfile['voucher_catalog_id']]);
    }

    public function voucherDetail($id)
    {
        $voucher = $this->repository->getVoucherDraftById($id);
        $responseCode = $this->getResponseCodeFromJson($voucher);
        if ($responseCode == 404) {
            return $this->pageNotFound();
        }
        $voucher = $this->getDataFromJson($voucher);
        return view('voucher.voucher_form_detail', compact('voucher'));
    }

    public function saveVoucherDetail(Request $request, $id)
    {
        $voucher = $this->repository->createVoucherDetail($request, $id);
        $voucherProfile = $this->getDataFromJson($voucher);
        return redirect()->route('voucher.merchant', ['id' => $voucherProfile['voucher_catalog_id']]);

    }

    public function voucherMercant($id)
    {
        $voucher = $this->repository->getVoucherDraftById($id);
        $responseCode = $this->getResponseCodeFromJson($voucher);
        $merchantDropdown = $this->getDataFromJson($this->merchantRepository->getMerchant())->unique();

        if ($responseCode == 404) {
            return $this->pageNotFound();
        }
        $voucher = $this->getDataFromJson($voucher);
        return view('voucher.voucher_form_merchant', compact('voucher', 'merchantDropdown'));
    }

    public function getOutlet($merchantId)
    {
        $data = $this->outletRepository->getOutletByMercahantId($merchantId);
        $responseCode = $this->getResponseCodeFromJson($data);
        if ($responseCode == 404) {
            //return $this->pageNotFound();
        }
        $outlet = $this->getDataFromJson($data);

        return $outlet;
    }

    public function saveVoucherMercant(Request $request, $voucherCatalogId)
    {
        $data = $this->repository->saveVoucherMerchant($request, $voucherCatalogId);
        $responseCode = $this->getResponseCodeFromJson($data);
        if ($responseCode != 201) {

        }
        $voucher = $this->getDataFromJson($data);

        return redirect()->route('voucher.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

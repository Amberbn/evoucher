<?php

namespace App\Http\Controllers\Web;

use App\Http\Repository\OutletRepository;
use App\Http\Repository\VoucherCatalogRepository;
use App\Repository\MerchantRepository;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

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
        $tags = $this->getDataFromJson($this->repository->getVoucherCatalogTags());
        return view('voucher.index', compact('tags'));
    }

    public function indexDatatable()
    {
        $voucher = $this->repository->voucherCatalogDatatable();
        $vouchers = $this->getDataFromJson($voucher);

        return Datatables::of($vouchers)
            ->addIndexColumn()
            ->addColumn('action', function ($voucher) {
                return '<td class="first">' .
                '<div class="form-check">' .
                '<input type="checkbox" id="' . $voucher->voucher_catalog_id . '" value="' . $voucher->voucher_catalog_id . '" class="form-check-input checkbox-list" nice-checkbox-radio />' .
                    '</div>' .
                    '</td>';
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

    public function editVoucheProfile($id)
    {
        if (!$id) {
            return $this->pageNotFound();
        }

        $voucher = $this->repository->getAllVoucherCatalog($id);
        $responseCode = $this->getResponseCodeFromJson($voucher);
        if ($responseCode == 404) {
            return $this->pageNotFound();
        }
        $voucherCategory = $this->getSettings(['voucher_category_pid']);
        $tags = $this->repository->getVoucherCatalogTags();
        $tagsData = $this->getDataFromJson($tags);

        $voucher = $this->getDataFromJson($voucher)->first();

        return view('voucher.voucher_form', compact('voucher', 'voucherCategory', 'tagsData'));

    }

    public function editVoucherDetail($id)
    {
        if (!$id) {
            return $this->pageNotFound();
        }

        $voucher = $this->repository->getVoucherDraftById($id, false);
        $responseCode = $this->getResponseCodeFromJson($voucher);
        if ($responseCode == 404) {
            return $this->pageNotFound();
        }
        $notEditable = true;
        $voucher = $this->getDataFromJson($voucher);

        return view('voucher.voucher_form_detail', compact('voucher', 'notEditable'));
    }

    public function updateVoucherDetail(Request $request, $id)
    {
        $voucher = $this->repository->updateVoucherCatalogStock($request,$id);
        $responseCode = $this->getResponseCodeFromJson($voucher);
        if ($responseCode == 404) {
            return $this->pageNotFound();
        }

        return redirect()->route('voucher.index');

    }

    public function destroyFromArray(Request $request)
    {
        $multipleDelete = $this->repository->multipleDelete($request->data);
        $responseCode = $this->getResponseCodeFromJson($multipleDelete);
    }
}

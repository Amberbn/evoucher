<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\MerchantRepository;
use App\Repository\ClientRepository;
use App\Repository\RoleRepository;
use Yajra\Datatables\Datatables;    

class MerchantController extends BaseControllerWeb
{
    private $type = ['prezent', 'client'];

    protected $merchantRepository;
    protected $clientRepository;


    public function __construct()
    {
        $this->merchantRepository = new MerchantRepository;
        $this->clientRepository = new ClientRepository;
    }

    public function index()
    {
        return view('merchant.index');
    }

    public function indexDatatable()
    {
        $merchant = $this->merchantRepository->getAllMerchants();
        // dd("Jangkrik");
        $merchant = $this->getDataFromJson($merchant);
// dd($merchant);
        return Datatables::of($merchant)
            ->addIndexColumn()
            ->addColumn('action', function ($merchant) {
                return '<td class="first">' .
                '<div class="form-check">' .
                '<input type="checkbox" value="user_id_' . $merchant->merchant_id . '" class="form-check-input" nice-checkbox-radio />' .
                    '</div>' .
                    '</td>';
            })
             ->make(true);
       
    }

    public function create(Request $request)
    {
        $filter = [
            'client_id',
            'client_name',
            'client_legal_name',
        ];
        $clients = $this->getDropDownClient($this->clientRepository->getClient(), $filter);
        $bussinessCategory = $this->getSettings(['bussiness_category']);
        $edit = false;
        

        $data = compact(
            'edit',
            'clients',
            'bussinessCategory'
        );

        return view('merchant.merchant_form', $data);
    }

    public function store(Request $request)
    {
        $merchant = $this->merchantRepository->store($request);
        $responseCode = $this->getResponseCodeFromJson($merchant);
        if ($responseCode != 201) {

        }

        return redirect()->route('merchant.index');
    }
}

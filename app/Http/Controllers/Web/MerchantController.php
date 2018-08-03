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
        $merchant = $this->getDataFromJson($merchant);
        return Datatables::of($merchant)
            ->addIndexColumn()
            ->addColumn('action', function ($merchant) {
                return '<td class="first">' .
                '<div class="form-check">' .
                '<input type="checkbox" value="' . $merchant->merchant_id . '" class="form-check-input" nice-checkbox-radio />' .
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
        $parametersValue = $this->getSettings(['parameters_value']);
        $tags = $this->getDataFromJson($this->merchantRepository->getTags());

        $edit = false;
        
        $data = compact(
            'edit',
            'clients',
            'bussinessCategory',
            'parametersValue',
            'tags'
        );

        return view('merchant.merchant_form', $data);
    }

    public function store(Request $request)
    {
        $merchant = $this->merchantRepository->saveMerchant($request);
        $responseCode = $this->getResponseCodeFromJson($merchant);
        if ($responseCode != 201) {

        }
        $response = $this->getDataFromJson($merchant);

        return redirect()->route('outlet.create').'?merchant_id='.$merchant->id;
    }

    public function edit($id)
    {
        $merchantData = $this->merchantRepository->getMerchantById($id);
        $merchant = $this->getDataFromJson($merchantData)->first();
        $filter = [
            'client_id',
            'client_name',
            'client_legal_name',
        ];
        $clients = $this->getDropDownClient($this->clientRepository->getClient(), $filter);
        $bussinessCategory = $this->getSettings(['bussiness_category']);

        $tags = $this->getDataFromJson($this->merchantRepository->getTags());

        $edit = true;

         $data = compact(
            'merchant',
            'edit',
            'clients',
            'bussinessCategory',
            'tags'
        );

        return view('merchant.merchant_form', $data);
    }

     public function update(Request $request, $id)
    {
        $merchant = $this->merchantRepository->updateMerchant($request, $id);
        $responseCode = $this->getResponseCodeFromJson($merchant);
        if ($responseCode != 200) {

        }
        $response =  $this->getDataFromJson($merchant);
        // dd(route('outlet.create').'?merchant_id='.$response['merchant_id']);
         return redirect()->route('outlet.create').'?merchant_id='.$response['merchant_id'];
        // return redirect()->route('merchant.index');
    }
}

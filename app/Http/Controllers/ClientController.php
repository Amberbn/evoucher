<?php

namespace App\Http\Controllers;

use App\Repository\ClientRepository;
use App\Repository\GeneralSettingRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->repository = new ClientRepository;
        $this->settings = new GeneralSettingRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = [
            'address_city',
            'address_region',
            'salutation',
            'client_category',
            'campaign_category',
        ];

        $settings = $this->settings
            ->getAllSettings($filters, true)
            ->getData()->data;

        $users = (new UserRepository)
            ->getListUsername()->getData()->data;

        return view('client.index', compact('users', 'settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->repository->store($request);

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

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
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $industries = (new GeneralSettingRepository())
            ->getSetting('industry_category')->getData()->data;

        $employeeSize = (new GeneralSettingRepository())
            ->getSetting('employee_size_category')->getData()->data;

        $provinces = (new GeneralSettingRepository())
            ->getSetting('address_state_province')->getData()->data;

        $users = (new UserRepository)
            ->getListUsername()->getData()->data;

        // dd($employeeSize);

        return view('client.index', compact('industries', 'users', 'employeeSize', 'provinces'));
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

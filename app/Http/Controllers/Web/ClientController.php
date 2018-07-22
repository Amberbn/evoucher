<?php

namespace App\Http\Controllers\Web;

use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class ClientController extends BaseControllerWeb
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
        $filters = [
            'address_city',
            'address_region',
            'salutation',
            'client_category',
            'campaign_category',
        ];

        $settings = $this->getSettings($filters, true);

        $edit = false;

        $users = (new UserRepository)
            ->getListUsername()->getData()->data;

        return view('client.index', compact('users', 'settings', 'edit'));
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
        $response = $this->repository->store($request);
        $responseCode = $this->getResponseCodeFromJson($response);
        if ($responseCode != 201) {

        }
        return redirect()->route('client.index');

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
        $filters = [
            'salutation',
            'client_category',
            'campaign_category',
        ];

        $edit = true;

        $settings = $this->getSettings($filters, true);

        $users = (new UserRepository)
            ->getListUsername()->getData()->data;

        $client = $this->getDataFromJson((new ClientRepository)
                ->getClient($id))->first();

        if (!$client) {
            return $this->pageNotFound();
        }

        return view('client.index', compact('users', 'settings', 'edit', 'client'));

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
        $upddate = $this->repository->update($request, $id);
        $responseCode = $this->getResponseCodeFromJson($upddate);
        if ($responseCode != 200) {

        }
        return redirect()->route('client.index');
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

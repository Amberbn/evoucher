<?php

namespace App\Http\Controllers\Web;

use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserController extends WebController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    public function indexDatatable()
    {
        $data = $this->guzzleGet('user-datatable');
        $users = new Collection($data);
        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                return '<td class="first">' .
                    '<div class="form-check">' .
                    '<input type="checkbox" value="user_id_' . $user['user_id'] . '" class="form-check-input" nice-checkbox-radio />' .
                    '</div>' .
                    '</td>';
            })
            ->editColumn('user_roles', function ($userRoles) {
                $role = $userRoles['user_roles'] ?: 'Ngawur';
                return $role;
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

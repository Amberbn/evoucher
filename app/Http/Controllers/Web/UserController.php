<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseControllerWeb;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\User;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseControllerWeb
{
    /**
     *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
     */
    public function __construct()
    {
        $this->model = new User;
        $this->repository = new UserRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('users.index');
    }

    public function indexDatatable()
    {
        $users = $this->repository->userIndexDatatable();
        $users = $this->getDataFromJson($users);

        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                return '<td class="first">' .
                '<div class="form-check">' .
                '<input type="checkbox" value="user_id_' . $user->user_id . '" class="form-check-input" nice-checkbox-radio />' .
                    '</div>' .
                    '</td>';
            })
            ->editColumn('user_roles', function ($userRoles) {
                $role = $userRoles->user_roles ?: 'Ngawur';
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
        $settings = $this->getSettings(['salutation']);
        $edit = false;
        $roles = $this->getDataFromJson((new RoleRepository)
                ->getRole([
                    'roles_id',
                    'roles_description',
                ]));
        return view('users.user_form', compact('settings', 'roles', 'edit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->repository->saveUser($request);
        $responseCode = $this->getResponseCodeFromJson($user);
        if ($responseCode != 200) {

        }
        return redirect()->route('user.index');

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
        $settings = $this->getSettings(['salutation']);
        $edit = true;
        $roles = $this->getDataFromJson((new RoleRepository)
                ->getRole([
                    'roles_id',
                    'roles_description',
                ]));
        $user = $this->getDataFromJson($this->repository->getAllUser($id))->first();
        if (!$user) {
            return $this->pageNotFound();
        }

        return view('users.user_form', compact('settings', 'roles', 'edit', 'user'));
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
        $upddate = $this->repository->updateUser($request, $id);
        $responseCode = $this->getResponseCodeFromJson($upddate);
        if ($responseCode != 200) {

        }
        return redirect()->route('user.index');

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

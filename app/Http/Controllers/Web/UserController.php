<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseControllerWeb;
use App\Repository\ClientRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\User;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseControllerWeb
{
    private $type = ['prezent', 'client'];

    /**
     *FUNCTION __construct FOR DEFINE MODEL AND REPOSITORY
     */
    public function __construct()
    {
        $this->model = new User;
        $this->repository = new UserRepository;
        $this->client = new ClientRepository;
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
                '<input type="checkbox" id="' . $user->user_id . '" value="' . $user->user_id . '" class="form-check-input" nice-checkbox-radio />' .
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
    public function create(Request $request)
    {
        $type = $request->type == 'prezent' ? 'prezent' : 'client';
        $settings = $this->getSettings(['salutation']);
        $filter = [
            'client_id',
            'client_name',
            'client_legal_name',
        ];
        $clients = $this->getDropDownClient($this->client->getClient(), $filter);
        $sprintClient = $type == 'prezent';
        $edit = false;
        $roles = $this->getDataFromJson(
            (new RoleRepository)
                ->getRole([
                    'roles_id',
                    'roles_description',
                ])
        );

        $data = compact(
            'settings',
            'roles',
            'edit',
            'type',
            'clients',
            'sprintClient'
        );

        return view('users.user_form', $data);
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
    public function edit(Request $request, $id)
    {
        $type = $request->type == 'prezent' ? 'prezent' : 'client';

        $settings = $this->getSettings(['salutation']);
        $edit = true;
        $roles = $this->getDataFromJson(
            (new RoleRepository)
                ->getRole([
                    'roles_id',
                    'roles_description',
                ])
        );

        $user = $this->getDataFromJson(
            $this->repository->getAllUser($id)
        )->first();

        $filter = [
            'client_id',
            'client_name',
            'client_legal_name',
        ];
        $clients = $this->getDropDownClient($this->client->getClient(), $filter);

        if (!$user) {
            return $this->pageNotFound();
        }

        $sprintClient = $this->isSprintClient($user->client_id);

        $data = compact(
            'settings',
            'roles',
            'edit',
            'user',
            'type',
            'clients',
            'sprintClient'
        );

        return view('users.user_form', $data);
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

    public function destroyFromArray(Request $request)
    {
        $multipleDelete = $this->repository->multipleDelete($request->data);
        $responseCode = $this->getResponseCodeFromJson($multipleDelete);
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

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Datatbase\Eloquent\Model;
use Illuminate\Routing\Controller as BaseController;
use DB;

class ApiController extends BaseController
{
    use App\Http\Controllers\Contract\ResponseTrait;

    const STATUS_ACTIVE = 'active';

    /**
     * Get authenticated & autorisation user with Api Token
     * @param Request $request
     * @param active
     * @param \Iluminate\Database\Eloquent\Model
     */

    public function index()
    {
        dd(DB::table('bsn_client')->get());
        // echo phpinfo();
    }
}

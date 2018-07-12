<?php

namespace App\Http\Controllers\Api;

use DB;
use Illuminate\Datatbase\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    use \App\Http\Controllers\Contract\ResponseTrait;
    use \App\Http\Controllers\Contract\UserTrait;

    /**
     * Get authenticated & autorisation user with Api Token
     * @param Request $request
     * @param active
     * @param \Iluminate\Database\Eloquent\Model
     */

    public function index()
    {
        //for test db connection only
        // dd(DB::table('bsn_client')->get());
        // echo phpinfo();
        $res = DB::table('bsn_client')->get();
        return response()->json($res);
    }
}

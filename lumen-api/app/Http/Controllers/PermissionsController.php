<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Spatie\QueryBuilder\QueryBuilder;

class PermissionsController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('auth:api');
    }

    /**
     * Display a listing of the users.
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = $request->auth->getAllPermissions()->pluck('name')->toArray();

        return responder()->success($permissions)->respond();
    }
}

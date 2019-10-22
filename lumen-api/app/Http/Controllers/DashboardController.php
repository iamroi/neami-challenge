<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Spatie\QueryBuilder\QueryBuilder;

class DashboardController extends Controller
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
        $data = [];

        // get all users count for admins
        if($request->auth->hasPermissionTo('manage-users')) {
            $data = ['usersCount' => User::count()];
        }

        return responder()->success($data)->respond();
    }
}

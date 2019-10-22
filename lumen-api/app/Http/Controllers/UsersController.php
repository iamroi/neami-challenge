<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Spatie\QueryBuilder\QueryBuilder;

class UsersController extends Controller
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
        $users = QueryBuilder::for(User::class, $request)
                    ->allowedFilters('name')
//                    ->with('permissions')
                    ->paginate($request->limit);

        foreach ($users as $k => $user) {
            $user->getAllPermissions();
        }
        return responder()->success($users)->respond();
    }

    /**
     * Authenticate a given user.
     *
     * @param $request
     * @throws \Exception
     * @return \Illuminate\Http\Response
     */
    /*public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if(Hash::check($request->input('password'), $user->password)){
            $apikey = base64_encode(str_random(40));
            User::where('email', $request->input('email'))->update(['api_token' => "$apikey"]);;
            return response()->json(['status' => 'success','api_key' => $apikey]);
        }else{
            return response()->json(['status' => 'fail'],401);
        }
    }*/
}

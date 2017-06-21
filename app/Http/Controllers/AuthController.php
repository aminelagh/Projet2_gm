<?php

namespace App\Http\Controllers;

use Sentinel;
use Cartalyst\Sentinel as Sent;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('authentication.login');
    }

    public function login(Request $request){

        //$user = Sentinel::registerAndActive($request->all());
        dump($request);
        dump($request->all());

        dump(request());
        dump(request()->all());

        //dump($user);

    }
}

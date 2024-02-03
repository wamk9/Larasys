<?php

namespace App\Http\Controllers\Web;

use App\Facades\ApiConsumer;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->only([
            'email',
            'password'
        ]);

        $user = ApiConsumer::get('/auth/login', $data);

        dd($user);

        // if (!!$user)
        // {
        //     session()->put('token' )
        // }
    }
}

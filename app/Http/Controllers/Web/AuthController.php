<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Api;
use App\Providers\RouteServiceProvider;
use Cjmellor\BrowserSessions\Facades\BrowserSessions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AuthController extends Api\AuthController
{
    public function webLogin(Request $request)
    {
        $responseLogin = $this->login($request);

        if ($responseLogin->getStatusCode() == 200)
        {
            $request->session()->regenerate();
            $request->session()->put('token', $responseLogin->getData()->token);
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function webLogout(Request $request)
    {
        $responseLogin = $this->logout($request);

        if ($responseLogin->getStatusCode() == 200)
        {
            //Session::regenerate();
            //Session::invalidate();
            // Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
                //dd($request->session()->all());
            return redirect('/');
        }

    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Facades\ApiConsumer;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\AuthController;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $auth = new AuthController();
        $response = $auth->login($request);


        /*$data = $request->only([
            'email',
            'password'
        ]);

        //$user = ApiConsumer::post('/auth/login', $data);

        $apiConnection = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://localhost:8000/api/',
            'verify' => false,
            // You can set any number of default request options.
            'timeout'  => 5.0,
        ]);

        $response = $apiConnection->post('auth/login', $data);*/


        //$request->authenticate();

        //$request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

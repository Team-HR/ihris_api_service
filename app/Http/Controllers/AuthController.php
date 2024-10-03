<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * Handle an authentication attempt.
     */

    public function authenticate(Request $request) //: RedirectResponse
    {

        // return $request->username;
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return Auth::user();
            // return redirect()->intended('dashboard');
            // return "login success!";
        }

        return response(["message" => "The provided credentials do not match our records."], 401);
        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ])->onlyInput('email');
    }


    function logout()
    {
        Auth::logout();
    }
}

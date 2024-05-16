<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $this->credentials($request);
        // Attempt to log the user in
        if (Auth::guard('user')->attempt($credentials)) {
            // If successful, redirect to their intended location
            return redirect('/');
        }
        if (Auth::guard('admin')->attempt($credentials)) {
            return $this->sendLoginResponse($request);
        }

        // If unsuccessful, redirect back to the login with form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    public function logout(Request $request)
    {
        auth('user')->logout();
        return redirect('/');
    }
}

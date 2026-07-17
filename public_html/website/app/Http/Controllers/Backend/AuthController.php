<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post') === true) :
            $request->validate([
                'email'     => 'required|email|is_email_exist',
                'password'  => 'required|min:5|max:12',
            ]);
            $userInfo = User::where('email', $request->email)->first();
            if (Hash::check($request->password, $userInfo->password)) {
                $request->session()->put('userCredential', [
                    'user_id'       => $userInfo->id,
                    'name'          => $userInfo->name,
                    'email'         => $userInfo->email,
                    'is_login'      => true,
                ]);
                return redirect()->route('dashboard')->with('success', 'You are logged in.');
            } else {
                return back()->withInput()->with('error', 'Incorrect password.');
            }
        else :
            return view('backend.auth.login')->with('success', 'This is demo');
        endif;
    }

    public function Logout()
    {
        if (session()->has('userCredential')) {
            session()->pull('userCredential');
            return redirect()->route('login');
        }
        return back();
    }
}

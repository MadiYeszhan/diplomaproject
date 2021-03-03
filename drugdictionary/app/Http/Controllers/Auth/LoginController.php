<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected $redirectTo = '/admin';

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    public function loginForm(){
        return view('auth.login');
    }

    public function login(Request $request){
        $v = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        else {
            $credentials = $request->only('email', 'password');
            $rem = $request->has('remember');
            if (Auth::attempt($credentials, $rem)) {
                if (Auth::user()) {
                    return redirect()->route('admin.index');
                } elseif (!Auth::user()->hasVerifiedEmail()) {
                    return redirect()->route('verification.notice');
                } else
                    return redirect()->route('admin.index');
            } else
                return redirect()->route('loginform');
        }

    }

    public function logout(){

        Auth::logout();
        return redirect()->route('admin.index');
    }

}

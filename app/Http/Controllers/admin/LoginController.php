<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function index()
    {
        return view('admin.login.login');
    }

    public function loginCheck(LoginRequest $request)
    {
        $data = array(
            'email'     =>$request->get('email'),
            'password'  =>$request->get('password'),
        );
        
        if(Auth::attempt($data))
        { 
             return redirect()->route('admin.dashboard');
        }
        else
        {
            return back()->with('error',"Invalid Credentials");
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');

    }
}

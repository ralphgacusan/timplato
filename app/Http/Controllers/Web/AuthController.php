<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Show Sign up Page
    public function signupPage(){
        return view('auth.sign-up');
    }

    // Show Sign in Page
    public function signinPage(){
        return view('auth.sign-in');
    }
}

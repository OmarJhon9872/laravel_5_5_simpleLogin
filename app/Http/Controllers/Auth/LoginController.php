<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LoginController extends Controller{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    public function username(){
        return 'nombre';
    }

    protected function attemptLogin(Request $request){
        $user = User::where('nombre', $request->nombre)->where('password', $request->password);
        if($user->exists()){
            Auth::login($user->first(), $request->remember);
            return true;
        }
        return false;
    }

    protected function validateLogin(Request $request){
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'remember' => Rule::in(['on', 'off'])
        ]);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller{

    use ResetsPasswords;

    protected $redirectTo = '/';

    public function __construct(){
        $this->middleware('guest');
    }

    protected function rules(){
        return [
            'token' => 'required',
            'nombre' => 'required|string',
            'password' => 'required|confirmed|min:6',
        ];
    }

    protected function credentials(Request $request){
        return $request->only(
            'nombre', 'password', 'password_confirmation', 'token'
        );
    }

    public function showResetForm(Request $request, $token = null){
        $existe_token = User::where('remember_token', $token);
        if($existe_token->exists()){
            return view('auth.passwords.reset')->with(
                ['token' => $token, 'nombre' => $existe_token->first()->nombre]
            );
        }
        return redirect()->route('home');
    }

    public function reset(Request $request){
        $this->validate($request, $this->rules());

        $user = User::where('nombre', $request->nombre)->where('remember_token', $request->token);
        if($user->exists()){

            $user = $user->first();
            $user->password = $request->password;
            $user->save();

            Auth::loginUsingId($user->id);
            return redirect()->route('home');
        }
        return redirect()->back()->withErrors(['nombre' => trans('passwords.tokenUser')]);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller{


    use SendsPasswordResetEmails;

    public function __construct(){
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request){
        $this->validateEmail($request);

        $user = User::where('nombre', $request->nombre);
        if($user->exists()){
            $token = Str::random(60);
            $user = $user->first();
            $user->setRememberToken($token);
            $user->save();

            $user->sendPasswordResetNotification($token);

            return $this->sendResetLinkResponse('passwords.sent');
        }
        return $this->sendResetLinkFailedResponse($request, 'passwords.user');
    }

    protected function validateEmail(Request $request){
        $this->validate($request, ['nombre' => 'required|string']);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response){
        return back()->withErrors(
            ['nombre' => trans($response)]
        );
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

class NewPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $input = $request->only('email');
        $validator = Validator::make($input, [
        'email' => "required|email"
        ]);
        if ($validator->fails()) {
        return response(['errors'=>$validator->errors()->all()], 422);
        }
        $response =  Password::sendResetLink($input);
        if($response == Password::RESET_LINK_SENT){
        $message = "Mail send successfully";
        }else{
        $message = "Email could not be sent to this email address";
        }
        //$message = $response == Password::RESET_LINK_SENT ? 'Mail send successfully' : GLOBAL_SOMETHING_WANTS_TO_WRONG;
        $response = ['data'=>'','message' => $message];
        return response($response, 200);
    }

    public function reset(Request $request)
    {
        $input = $request->only('email','token', 'password', 'password_confirmation');
        $validator = Validator::make($input, [
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
        ]);
        if ($validator->fails()) {
        return response(['errors'=>$validator->errors()->all()], 422);
        }
        $response = Password::reset($input, function ($user, $password) {
        $user->forceFill([
        'password' => Hash::make($password)
        ])->save();
        //$user->setRememberToken(Str::random(60));
        event(new PasswordReset($user));
        });
        if($response == Password::PASSWORD_RESET){
        $message = "Password reset successfully";
        }else{
        $message = "Email could not be sent to this email address";
        }
        $response = ['data'=>'','message' => $message];
        return response()->json($response);
    }
}

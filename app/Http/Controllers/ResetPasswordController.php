<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showRecover_password($token, $email)
    {
        // echo $request->email;
        // return view('customauth.passwords.reset', ['token' => $token]);
        return view('/auth/recover_password', ['token' => $token, 'email' => $email]);
    }

    public function recover_passwordChk(Request $request)
    {

        $request->validate([
            // 'email' => 'required|email|exists:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'

        ]);

        $updatePassword = DB::table('password_resets')
            ->where(['email' => $request->email, 'token' => $request->token])
            ->first();

        if (!$updatePassword)
            return back()->withInput()->with('error', 'Invalid token!');

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('message', 'Your password has been changed!');
    }
}

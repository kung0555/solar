<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    //
    public function show()
    {
        return view('auth/register');
    }

    public function registerChk(RegisterRequest $request)
    {

        $user = User::create($request->validated());
        // $request->validated();
        // User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'remember_token' => "remember_token",
        //     'password' => Hash::make($request->password),
        // ]);

        auth()->login($user);    

        return redirect('/')->with('success', "Account successfully registered.");
    }
}

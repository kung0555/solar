<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersmanageController extends Controller
{
    public function viewUsers()
    {
        $allusers = User::all();
        return view('admin/usersmanage/allusers', compact('allusers'));
    }
    public function userEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin/usersmanage/userEdit', compact('user'));
    }
    public function updateUserChk(Request $request, $id)
    {
        $user_update = User::find($id);
        $user_update->is_admin = $request->is_admin;
        $user_update->receive_mail_billing = $request->receive_mail_billing;
        $user_update->save();
        return redirect()->route('viewUsers')->with('success', "บันทึกข้อมูล ID : " . $id . " เรียบร้อย");
    }
}

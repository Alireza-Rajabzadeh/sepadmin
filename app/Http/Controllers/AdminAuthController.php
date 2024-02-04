<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function getLogin()
    {


        // Admin::create([
        //     "email" => "test@gmail.com",
        //     "name" => "test@gmail.com",
        //     "password" => bcrypt("12345678")
        // ]);

        return view('admin.auth.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->guard('admin')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])) {


            $user = Auth::admin();

            

            if (!empty($user)) {
                return redirect()->route('adminDashboard')->with('success', 'You are Logged in sucessfully.');
            }
        } else {
            return back()->with('error', 'Whoops! invalid email and password.');
        }
    }

    public function adminLogout(Request $request)
    {
        auth()->guard('admin')->logout();
        Session::flush();
        Session::put('success', 'You are logout sucessfully');
        return redirect(route('adminLogin'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Auth;
use Session,Helper,Hash;
use App\Models\User;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('get'))
        {
          return view('admin-login');
        }
        else
        {
            $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            ], [
            'email.email' => 'Please Enter Valid Email Address',
            'email.required' => 'Please Enter Email Address',
            'password.required' => 'Please Enter Password',
            ]);


            $user_count =  User::where('email', $request->email)->where('is_admin', 1)->count();
            
            if($user_count > 0)
            {
              $user_record =  User::where('email', $request->email)->where('is_admin', 1)->first();
              $user_password = $user_record->password;

              if(password_verify($request->password, $user_password)) 
              {
                $request->session()->put('admin_id', $user_record->id);
                $request->session()->put('name', $user_record->name);

                return redirect('/admin/events');
              }
              else
              {
                return redirect()->back()->with('message', 'Not Valid Password.');
              }
            }
            else
            {
              return redirect()->back()->with('message', 'User not found');    
            }

        }
    }

    public function logout(Request $request)
    {
      Session::flush();
      Auth::logout();
      return redirect('/admin/login');
    }
}
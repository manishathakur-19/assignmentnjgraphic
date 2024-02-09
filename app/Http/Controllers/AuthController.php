<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Auth;
use Session,Helper,Hash;
use App\Models\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        if ($request->isMethod('get'))
        {
            return view('register');
        }
        else
        {
            $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            ], [
            'name.required' => 'Please Enter Name',
            'email.required' => 'Please Enter Email Address',
            'email.unique' => 'Email Address is already in use',
            'email.email' => 'Please Enter Valid Email Address',
            'password.required' => 'Please Enter Password',
            ]);


            $user_data = new User;

            $user_data->name = $request->name;
            $user_data->email = $request->email;
            $user_data->password = Hash::make($request->password);
            $user_data->created_at = date("Y-m-d H:i:s");

            $insert_user_data = $user_data->save();

            if($insert_user_data)
            {
              return redirect('/register')->with('message', 'User Created Successfully');
            }
        }
    }

    public function login(Request $request)
    {
        if ($request->isMethod('get'))
        {
            return view('login');
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


            $user_count =  User::where('email', $request->email)->where('is_admin', 0)->count();
            
            if($user_count > 0)
            {
              $user_record =  User::where('email', $request->email)->where('is_admin', 0)->first();
              $user_password = $user_record->password;

              if(password_verify($request->password, $user_password)) 
              {
                $request->session()->put('user_id', $user_record->id);
                $request->session()->put('name', $user_record->name);

                return redirect('/user/dashboard');
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

    public function dashboard(Request $request)
    {
      $user_id = $request->session()->get('user_id');

      $data['user_data'] = User::where('id', $user_id)->first();

      return view('dashboard', $data); 
    }


    public function logout(Request $request)
    {
      Session::flush();
      Auth::logout();
      return redirect('/login');
    }

}

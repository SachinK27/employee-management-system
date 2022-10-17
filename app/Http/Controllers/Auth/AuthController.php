<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Mail;
use App\Mail\RegistrationMail;



class AuthController extends Controller
{
    public function saveUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobNo' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'department' => 'required'

        ]);
        $password=Str::random(10);
        $user= new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone=$request->mobNo;
        $user->gender=$request->gender;
        $user->dob=$request->dob;
        $user->level="level1";
        $user->department=$request->department;
        $user->subordinate_to="admin";
        $user->password=$password;
        $user->hire_date=Carbon::now();
        $user->status="active";
        $mailData = [
            'email' => $request->email,
            'password' => $password,
        ];

        Mail::to($request->email)->send(new RegistrationMail($mailData));
        $user->save();
           
        echo "registration successfull and email send successfully";
        exit;
                

    }
}

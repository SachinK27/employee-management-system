<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\departments;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Mail;
use App\Mail\RegistrationMail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Hash;
use Session;
 



class AuthController extends Controller
{
    public function users()
    {
        $data=departments::all();
        return view('admin.registration',compact('data'));
    }   
    public function saveUser(Request $request)
    {
       
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|min:10',
            'gender' => 'required',
            'dob' => 'required|date',
            'department' => 'required',
            'level' => 'required|int',

        ]);
        
        
        $password=Str::random(10);
        $user= new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->gender=$request->gender;
        $user->dob=$request->dob;
        $user->level=$request->level;
        $user->department=$request->department;
        if($request->level==3)
        {
            $user->subordinate_to=$request->subordinateTo;
        }
        else
        {
            $user->subordinate_to=0;
        }
        if($request->level==1)
        {
            $role=2;
        }
        if($request->level==2)
        {
            $role=3;
        }
        if($request->level==3)
        {
            $role=4;
        }
        $user->role=$role;       
        $user->password=Hash::make($password);
        $user->hire_date=Carbon::now();
        $user->status="active";
        $mailData = [
            'email' => $request->email,
            'password' => $password,
        ];
         
        Mail::to($request->email)->send(new WelcomeMail($mailData));
        $result=$user->save();
           if($result)
           {
            return redirect()->back()->with('success','user Created Successfully and mail with password sent successfully');
           }
           else
           {
            return redirect()->back()->with('fail','opeartion fail please try again');
           }
        
                

    }
    public function getPlead(Request $request)
    {
        if($request->level==3)
        {
            $Plead = User::where('isAdmin',0)->where('level',2)->get(['id','name']);
            //  $Phead = User::all();
             return response()->json($Plead);
        }
        
   
    }
    public function logout()
    {
        auth()->logout();
        Session::flush();
        return redirect()->route('home');
    }
}

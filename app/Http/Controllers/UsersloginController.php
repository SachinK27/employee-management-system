<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Hash;
class UsersloginController extends Controller
{

   
    public function LoginPage(){

        return view('admin/login');

    }

    public function CheckUsers(Request $request){
        $request->validate([
            'email' => 'required',
            'password'=> 'required'
        ]);

        $users=User::where('email','=',$request->email)->first();

        if($users){
            if(Hash::check($request->password,$users->password)){

                if($users->isAdmin == 1 && $users->status = 'active'){ 
                    $request->session()->put('adminLoginId',$users->id);
                    return redirect('/admin/dashboard');
                }
                elseif($users->isAdmin == 0 ){
                    if($users->level == 1 && $users->status == 'active' ){
                        $request->session()->put('level1loginId',$users->id);
                        return redirect('level1/dashboard');
                    }
                    elseif($users->level == 2 && $users->status == 'active'){
                        $request->session()->put('level2loginId',$users->id);
                        return redirect('level2/dashboard');
                    }
                    elseif($users->level == 3 && $users->status == 'active'){
                        $request->session()->put('level3loginId',$users->id);
                        return redirect('level3/dashboard');
                    }
                }else{
                    return redirect('/login')->with('error1','incorrect email or password.');
                }
                
            }else{
                return redirect('/login')->with('error1','incorrect email or password.');
            }
       
        }else{
            return redirect('/login')->with('error2','you dont have account.');
        }
    }
        

        public function Admin_logout(){

            if(Session::has('adminLoginId')){
                Session::pull('adminLoginId');
                return redirect('/login');
            }
        }

            public function level1_logout(){

                if(Session::has('level1loginId')){
                    Session::pull('level1loginId');
                    return redirect('/login');
                }
            }

            public function level2_logout(){

                if(Session::has('level2loginId')){

                    Session::pull('level2loginId');
                    return redirect('/login');
                }
            }

            public function level3_logout(){

                if(Session::has('level3loginId')){

                    Session::pull('level3loginId');
                    return redirect('/login');
                }
            }



           

         

}

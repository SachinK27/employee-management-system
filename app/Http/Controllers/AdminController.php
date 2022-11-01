<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Session;
use App\Models\departments;
class AdminController extends Controller
{   
    // public function __construct()
    // {
    //     $this->middleware('isAdmin');
    // }
    public function users()
    {
        $data=departments::all();
        $user=User::all();
        return view('admin.registration',compact(['data','user']));
    }   
    // admin dashboard
    public function Admin_Dashboard(){

        $data=array();
        if(Session::has('adminLoginId')){
            $data=User::where('id' , '=' ,Session::get('adminLoginId'))->first();
        }
        return view('admin.index',compact('data'));

    }
}

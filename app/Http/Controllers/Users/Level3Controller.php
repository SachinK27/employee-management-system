<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\User;
use App\Models\task;
class Level3Controller extends Controller
{
    //

     public function index(){

            $level3=array();
            if(Session::has('level3loginId')){
            $level3=User::where('id' , '=' , Session::get('level3loginId'))->first();
            $data=task::where('assigned_to',$level3->name)->get();
            return view('user.level3.indexx',compact(['level3','data']));
            }
            
        }
}

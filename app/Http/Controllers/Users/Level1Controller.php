<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\task;
use Hash;
use Session;
class Level1Controller extends Controller
{
    //
        public function index(){
            $level1= array();
            if(Session::has('level1loginId')){
            $level1=User::where('id' , '=' ,Session::get('level1loginId'))->first();
            $tasks=task::where('assigned_to',$level1->id)->get();
            return view('user.level1.index',compact(['level1','tasks']));
            }
            
        }
}

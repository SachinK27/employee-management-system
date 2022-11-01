<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\task;
use Hash;
use Session;
use Auth;
class Level1Controller extends Controller
{
    //
        // public function index(){
        //     $level1= array();
        //     if(Session::has('level1loginId')){
        //     $level1=User::where('id' , '=' ,Session::get('level1loginId'))->first();
        //     $tasks=task::where('assigned_to',$level1->id)->get();
        //     return view('user.level1.index',compact(['level1','tasks']));
        //     }
            
        // }
        public function index(){
            $id=Auth::id();
            $tasks=task::where('assigned_to',$id)->get();
            $level1 = User::where('id', Auth::id())->first();
            return view('user.level1.index', compact(['level1','tasks']));            
        }
}

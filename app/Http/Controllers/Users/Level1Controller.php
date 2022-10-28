<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Session;
class Level1Controller extends Controller
{
    //
        public function index(){
            $level1= array();
            if(Session::has('level1loginId')){
            $level1=User::where('id' , '=' ,Session::get('level1loginId'))->first();
            return view('user.level1.index',compact('level1'));
            }
            
        }
}

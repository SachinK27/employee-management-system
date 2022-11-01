<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\User;
use Auth;
use App\Models\task;
class Level3Controller extends Controller
{
    //

    //  public function index(){

    //         $level3=array();
    //         if(Session::has('level3loginId')){
    //         $level3=User::where('id' , '=' , Session::get('level3loginId'))->first();
    //         $data=task::where('assigned_to',$level3->id)->get();
    //         return view('user.level3.index',compact(['level3','data']));
    //         }
            
    //     }
    public function index(){
        $level3 = User::where('id', Auth::id())->first();
        $data = task::where('assigned_to', $level3->id)->get();
        return view('user.level3.index', compact(['level3','data']));
    }
}

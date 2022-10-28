<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\task;

use Session;
class Level2Controller extends Controller
{
    //

    public function index(){

            $level2=array();
            if(Session::has('level2loginId')){
            $level2=User::where('id' , '=' , Session::get('level2loginId'))->first();
            $data=task::where('assigned_to',$level2->id)->get();
            return view('user.level2.indexx',compact(['level2','data']));
            }
           
        
    }
    public function level3Task()
    {
        $id=Session::get('level2loginId');
        $subordinate=User::where('subordinate_to',$id)->get('id');
        $id2=[];


        foreach($subordinate as $subordinates)
        {
            $id2[]=$subordinates->id;
            // $listing->where('assigned_to',$subordinates->id)->get();
            
        }
        // $output = implode(",",$id2);
        $tasks=task::whereIn('assigned_to',$id2)->get();
        return view('user.level2.viewLevel3Task',compact('tasks'));
        
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\departments;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\task;
class HomeController extends Controller
{
    public function landing()
    {
        return view('admin.login');
    }
    public function test()
    {
        return view('admin.indexx');
    }
    public function registration()
    {
        $data=departments::all();
        return view('admin.index',compact('data'));
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function level3()
    {
      $allTask=task::all();
    //   foreach($allTask as $tasks)
    //   {
    //     $assign_date=$tasks->assign_date;
    //     $monthNum=substr($assign_date,2,2);
    //     $month_name = date("F", mktime(0, 0, 0, $monthNum, 10));
    //     $assignDate=date('d', strtotime($tasks->assign_date));
    //     $assignnDatee=$assignDate."-".$month_name;
    //     $tasks->assign_date=$assignnDatee;
    //    }

        return view('user.level3.my-task',compact('allTask'));
    }
    public function changeStatus(Request $request,$id)
    {
     $status=$request->status;
     $task=task::find($id);
     $task->status=$status;
    $result=$task->save();
    if($result)
    {
        return redirect()->route('l3dash')->with('success','status updated successfully');
    }
    else
    {
        return redirect()->route('l3dash')->with('fail','failed please try again');
    }
    }
    public function updateStatus(Request $request)
    {
       
        $request->validate([
            'status' => 'required',
            ]);
            $id=$request->id;
            $task=task::find($id);
            $task->notes=$request->note;
            $task->status=$request->status;
            $result=$task->save();
            if($result)
            {
                return redirect()->back()->with('success','status updated successfully');
            }
            else
            {
                return redirect()->back()->with('fail','failed please try again');
            }

            
    }
    public function updateStatuss(Request $request)
    {
       
        $request->validate([
            'status' => 'required',
            ]);
            $id=$request->id;
            $task=task::find($id);
            $task->notes=$request->note;
            $task->status=$request->status;
            $result=$task->save();
            if($result)
            {
                return redirect()->back()->with('success','status updated successfully');
            }
            else
            {
                return redirect()->back()->with('fail','failed please try again');
            }

            
    }
}

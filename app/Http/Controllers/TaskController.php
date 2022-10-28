<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Company;
use App\Models\User;
use App\Models\Notification;
use Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index() {
        $allTask = Task::get();
        $allNotification = Notification::get();
        return view('user.level2.my-task', compact('allTask','allNotification'));
    }

    public function createTask(Request $request) {

        $request->validate([
            'desc' => 'required',
            'assignTo' => 'required',
            'company' => 'required',
            'priority' => 'required',
            'deadline' => 'required',
        ]);

        $newTask = new Task();
        $newTask->task = $request->input('desc');
        $newTask->assigned_by = '1'; //logged in user id will be stored
        $newTask->assigned_to = $request->input('assignTo');
        $newTask->assign_date = Carbon::now()->toDateTimeString();
        $newTask->deadline = $request->input('deadline');
        $newTask->status = '1';
        $newTask->priority = $request->input('priority');
        $newTask->company = $request->input('company');
        $result = $newTask->save();

        if($result)
           {
            return redirect()->back()->with('success', 'Task Created Successfully');
            
           }
           else
           {
            return redirect()->back()->with('fail','opeartion fail please try again');
           }
    }

    public function getUsers() {
        $allUsers = User::where('isAdmin',0)->get(['id','name']);
        return response()->json($allUsers);
    }

    public function getCOmpany() {
        $allCompany = Company::get(['id','name']);
        return response()->json($allCompany);
    }
}

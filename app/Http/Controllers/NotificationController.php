<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function list()
    {
        $list = Notification::get();

        return view('admin.notification', compact('list'));
    }

    public function create(Request $request)
    {   
        $request->validate([
            'notification' => 'required',
        ]);

        $new = new Notification;
        $new->notification = $request->input('notification');
        $result = $new->save();

        if($result){
            return redirect()->back()->with('success', 'Notification added Successfully');
        }
        else{
            return redirect()->back()->with('fail','opeartion fail please try again');
        }
    }
}

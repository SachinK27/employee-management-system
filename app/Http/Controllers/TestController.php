<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\WelcomeMail;

class TestController extends Controller
{
    public function index(){

        $mailData = [
            'title' => 'This is a Test mail',
            'body' => 'Success'
        ];
         
        Mail::to('sachinkumar1673@gmail.com')->send(new WelcomeMail($mailData));
           
        dd("Email is sent successfully.");
    }
}

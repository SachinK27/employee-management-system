<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CookieController extends Controller
{
    public function create(Request $request) {
        $name = $request->input('name');
        $value = $request->input('value');
        $time = $request->input('time') != '' ? $request->input('time') : null;
        $response = new Response('Set Cookie');
        $response->withCookie(cookie($name, $value, $time));
        return $response;
    }

    public function fetch(Request $request) {
        $name = $request->input('name');
        $value = $request->cookie($name);
        return $value;
    }

    public function remove(Request $request) {
        $name = $request->input('name');
        $response = new Response('Remove Cookie');
        $response->withoutCookie($name);
        return $response;
    }
}

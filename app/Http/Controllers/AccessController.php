<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccessController extends Controller
{
    public function index()
    {
        return view('access');
    }

    
    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        if (trim($request->code) !== trim(env('ACCESS_CODE'))) {
            return back()->withErrors([
                'code' => 'Access code salah'
            ]);
        }

        session()->put('access_granted', true);
        session()->save();

        return redirect()->route('login');
    }




}


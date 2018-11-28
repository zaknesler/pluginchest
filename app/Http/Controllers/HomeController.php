<?php

namespace App\Http\Controllers;

use App\Models\Plugin;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plugins = Plugin::latest()->with('users')->paginate(25);

        return view('home', compact('plugins'));
    }
}

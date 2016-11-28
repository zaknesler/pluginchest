<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user setting's page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illluminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('settings.index')
            ->with('user', $request->user());
    }
}

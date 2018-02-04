<?php

namespace App\Http\Controllers\Plugin;

use App\Models\PluginFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PluginFileController extends Controller
{
    /**
     * Display a listing of the file.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new file.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // store temporary file
        // dispatch job to validate file
            // unzip .jar to location
            // verify that plugin.yml exists
            // ensure that the name, version, author, description, and main settings exist
            // match "main" location from plugin.yml with directories
    }

    /**
     * Display the specified file.
     *
     * @param  \App\Models\PluginFile  $pluginFile
     * @return \Illuminate\Http\Response
     */
    public function show(PluginFile $pluginFile)
    {
        //
    }

    /**
     * Show the form for editing the specified file.
     *
     * @param  \App\Models\PluginFile  $pluginFile
     * @return \Illuminate\Http\Response
     */
    public function edit(PluginFile $pluginFile)
    {
        //
    }

    /**
     * Update the specified file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PluginFile  $pluginFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PluginFile $pluginFile)
    {
        //
    }

    /**
     * Remove the specified file from storage.
     *
     * @param  \App\Models\PluginFile  $pluginFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(PluginFile $pluginFile)
    {
        //
    }
}

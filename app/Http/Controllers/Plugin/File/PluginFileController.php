<?php

namespace App\Http\Controllers\Plugin\File;

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
    public function store(Request $request, Plugin $plugin)
    {
        $file = $plugin->files()->create([
            'name' => request('name'),
            'description' => request('description'),
            'stage' => request('stage'),
            'game_version' => request('game_version'),
        ]);

        $file->users()->associate(auth()->user());

        $file->storeTemporaryFile(request()->file('plugin_file'));

        return redirect()->route('plugins.show', $plugin);
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

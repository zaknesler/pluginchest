<?php

namespace App\Http\Controllers\Plugin;

use App\Models\Plugin;
use App\Models\PluginFile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PluginFileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], [
            'except' => [
                'index',
                'show',
            ],
        ]);
    }

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
     * @param  \App\Models\Plugin $plugin
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Plugin $plugin)
    {
        $this->authorize('createPluginFile', $plugin);

        return view('plugins.files.create', compact('plugin'));
    }

    /**
     * Store a newly created file in storage.
     *
     * @param  \App\Models\Plugin  $plugin
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Plugin $plugin, Request $request)
    {
        $this->authorize('createPluginFile', $plugin);

        $request->validate([
            'name' => 'required|min:2',
            'description' => 'required|min:20',
            'stage' => ['required', Rule::in(config('pluginchest.file_stages'))],
            'game_version' => ['required', Rule::in(config('pluginchest.game_versions'))],
            'plugin_file' => 'required|file',
        ]);

        $file = $plugin->files()->create([
            'name' => request('name'),
            'description' => request('description'),
            'stage' => request('stage'),
            'game_version' => request('game_version'),
            'user_id' => request()->user()->id,
        ]);

        $file->store(request()->file('plugin_file'));

        return redirect($plugin->getUrl());
    }

    /**
     * Display the specified file.
     *
     * @param  \App\Models\PluginFile  $pluginFile
     * @return \Illuminate\Http\Response
     */
    public function show(PluginFile $pluginFile)
    {
        // Ensure plugin file is approved.
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
     * @param  \App\Models\Plugin  $plugin
     * @param  \App\Models\PluginFile  $pluginFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plugin $plugin, PluginFile $pluginFile)
    {
        $this->authorize('delete', $pluginFile);

        Storage::disk(config('pluginchest.storage.validated'))->delete($pluginFile->file_name);

        $pluginFile->delete();

        return redirect($plugin->getUrl());
    }
}

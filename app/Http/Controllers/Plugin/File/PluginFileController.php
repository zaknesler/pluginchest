<?php

namespace App\Http\Controllers\Plugin\FIle;

use Storage;
use App\Plugin;
use App\PluginFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Plugins\Files\StorePluginFile;
use App\Jobs\Plugins\Files\DeletePluginFile;
use App\Http\Requests\Plugins\Files\CreateFileFormRequest;

class PluginFileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'index',
                'show'
            ]
        ]);
    }

    /**
     * Display all of the files that belong to the given plugin.
     *
     * @param  App\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function index(Plugin $plugin)
    {
        $files = $plugin->files()->hasFile()->latest()->get();

        return view('plugins.files.index')
            ->with('plugin', $plugin)
            ->with('files', $files);
    }

    /**
     * Show the form for creating a new plugin file.
     *
     * @param  App\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function create(Plugin $plugin)
    {
        return view('plugins.files.create')
            ->with('plugin', $plugin);
    }

    /**
     * Store the file data in the database and upload the file to storage.
     *
     * @param  App\Http\Requests\Plugins\File\CreateFileFormRequest  $request
     * @param  App\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFileFormRequest $request, Plugin $plugin)
    {
        $file = $plugin->files()->create([
            'name' => $request->input('name'),
            'summary' => $request->input('summary'),
            'stage' => $request->input('stage'),
            'game_version' => $request->input('game_version'),
        ]);

        $request->file('file')->move(
            config('filesystems.disks.local-plugin-files.root'),
            $fileId = uniqid(true)
        );

        $this->dispatch(new StorePluginFile($file, $fileId));

        flash('Your file has been uploaded. It will not be displayed to the public until it is approved by a moderator.');

        return redirect()->route('plugins.show', [
            $plugin->slug,
            $plugin->id
        ]);
    }

    /**
     * Display the specified file.
     *
     * @param  App\Plugin  $plugin
     * @param  App\PluginFile  $pluginFile
     * @return \Illuminate\Http\Response
     */
    public function show(Plugin $plugin, PluginFile $pluginFile)
    {
        if ($pluginFile->plugin_id !== $plugin->id) {
            return abort(404);
        }

        return view('plugins.files.show')
            ->with('plugin', $plugin)
            ->with('file', $pluginFile);
    }

    /**
     * Show the form for editing the specified file.
     *
     * @param  App\Plugin  $plugin
     * @param  App\PluginFile  $pluginFile
     * @return \Illuminate\Http\Response
     */
    public function edit(Plugin $plugin, PluginFile $pluginFile)
    {
        //
    }

    /**
     * Update the specified file in the database and reupload the file if necessary.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Plugin  $plugin
     * @param  App\PluginFile  $pluginFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plugin $plugin, PluginFile $pluginFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Plugin  $plugin
     * @param  App\PluginFile  $pluginFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plugin $plugin, PluginFile $pluginFile)
    {
        if ($pluginFile->plugin_id !== $plugin->id) {
            return abort(404);
        }

        $this->dispatch(new DeletePluginFile($pluginFile));

        return redirect()->route('plugins.show', [$plugin->slug, $plugin->id]);
    }
}

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
use App\Http\Requests\Plugins\Files\UpdateFileFormRequest;

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
        $this->authorize('createPluginFile', $plugin);

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
        $this->authorize('createPluginFile', $plugin);

        $file = $plugin->files()->create([
            'user_id' => $request->user()->id,
            'name' => $request->input('name'),
            'summary' => $request->input('summary'),
            'stage' => $request->input('stage'),
            'game_version' => $request->input('game_version'),
        ]);

        $request->file('file')->move(
            config('filesystems.disks.local-plugin-files.root'),
            $fileId = uniqid(true) . str_random(5)
        );

        $this->dispatch(new StorePluginFile($file, $fileId));

        flash('File has been created. Please allow some time for it to finish uploading.');

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
        $this->authorize('update', $pluginFile);

        return view('plugins.files.edit')
            ->with('plugin', $plugin)
            ->with('file', $pluginFile);
    }

    /**
     * Update the specified file in the database and reupload the file if necessary.
     *
     * @param  App\Http\Requests\Plugins\Files\UpdateFileFormRequest  $request
     * @param  App\Plugin  $plugin
     * @param  App\PluginFile  $pluginFile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileFormRequest $request, Plugin $plugin, PluginFile $pluginFile)
    {
        $this->authorize('update', $pluginFile);

        $pluginFile->update([
            'name' => $request->input('name'),
            'summary' => $request->input('summary'),
            'stage' => $request->input('stage'),
            'game_version' => $request->input('game_version'),
        ]);

        flash('File has been updated.');

        return redirect()->route('plugins.files.show', [
            $plugin->id,
            $pluginFile->id,
        ]);
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
        $this->authorize('delete', $pluginFile);

        if ($pluginFile->plugin_id !== $plugin->id) {
            return abort(404);
        }

        $this->dispatch(new DeletePluginFile($pluginFile));

        flash('File has been deleted.');

        return redirect()->route('plugins.show', [$plugin->slug, $plugin->id]);
    }
}

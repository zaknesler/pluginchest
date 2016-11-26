<?php

namespace App\Http\Controllers\Plugin;

use App\Plugin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Plugins\CreatePluginFormRequest;
use App\Http\Requests\Plugins\UpdatePluginFormRequest;

class PluginController extends Controller
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
     * Display a listing of the resource.
     *
     * @param  App\Plugin $plugin
     * @return \Illuminate\Http\Response
     */
    public function index(Plugin $plugin)
    {
        $plugins = $plugin->latest()->with('user')->paginate(10);

        return view('plugins.index')
            ->with('plugins', $plugins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Plugin::class);

        return view('plugins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Plugins\CreatePluginFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePluginFormRequest $request)
    {
        $this->authorize('create', Plugin::class);

        $plugin = $request->user()->plugins()->create([
            'name' => $request->input('name'),
            'slug' => str_slug($request->input('name')),
            'description' => $request->input('description'),
        ]);

        flash('Your plugin has been successfully created.');

        return redirect()->route('plugins.show', [$plugin->slug, $plugin->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @param  App\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Plugin $plugin)
    {
        if ($plugin->slug !== $slug) {
            return abort(404);
        }

        $plugin->load('user');

        $files = $plugin->files()->latest()->limit(3)->hasFile()->get();

        return view('plugins.show')
            ->with('plugin', $plugin)
            ->with('files', $files);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function edit(Plugin $plugin)
    {
        $this->authorize('update', $plugin);

        return view('plugins.edit')
            ->with('plugin', $plugin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Plugins\UpdatePluginFormRequest  $request
     * @param  App\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePluginFormRequest $request, Plugin $plugin)
    {
        $this->authorize('update', $plugin);

        $plugin->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('plugins.show', [$plugin->slug, $plugin->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plugin $plugin)
    {
        $this->authorize('delete', $plugin);
    }
}

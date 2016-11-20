<?php

namespace App\Http\Controllers\Plugin;

use App\Plugin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Plugins\CreatePluginFormRequest;

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plugin $plugin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plugin $plugin)
    {
        //
    }
}

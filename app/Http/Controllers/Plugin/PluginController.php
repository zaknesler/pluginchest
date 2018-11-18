<?php

namespace App\Http\Controllers\Plugin;

use App\Models\Plugin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Plugin\StorePlugin;

class PluginController extends Controller
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
     * Show the form for creating a new plugin.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plugins.create');
    }

    /**
     * Store a newly created plugin in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'description' => 'required|min:20',
        ]);

        $plugin = Plugin::create([
            'name' => request('name'),
            'description' => request('description'),
            'published_at' => null,
        ]);

        $plugin->users()->attach(request()->user(), ['role' => 'owner']);

        return redirect(route('plugins.show', [$plugin->slug, $plugin]));
    }

    /**
     * Display the specified plugin.
     *
     * @param  \App\Models\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function show(Plugin $plugin)
    {
        $plugin->load('users');

        return view('plugins.show', compact('plugin'));
    }

    /**
     * Show the form for editing the specified plugin.
     *
     * @param  \App\Models\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function edit(Plugin $plugin)
    {
        //
    }

    /**
     * Update the specified plugin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plugin $plugin)
    {
        //
    }

    /**
     * Remove the specified plugin from storage.
     *
     * @param  \App\Models\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plugin $plugin)
    {
        //
    }
}

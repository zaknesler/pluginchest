<?php

namespace App\Http\Controllers;

use App\Models\Plugin;
use Illuminate\Http\Request;

class PluginController extends Controller
{
    /**
     * Display a listing of the plugin.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new plugin.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created plugin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plugin = Plugin::create([
            'name' => request('name'),
            'description' => request('description'),
            'published_at' => null,
        ]);

        $plugin->users()->attach(request()->user(), ['is_creator' => true]);

        return redirect(route('plugins.show', $plugin));
    }

    /**
     * Display the specified plugin.
     *
     * @param  App\Models\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function show(Plugin $plugin)
    {
        //
    }

    /**
     * Show the form for editing the specified plugin.
     *
     * @param  App\Models\Plugin  $plugin
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
     * @param  App\Models\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plugin $plugin)
    {
        //
    }

    /**
     * Remove the specified plugin from storage.
     *
     * @param  App\Models\Plugin  $plugin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plugin $plugin)
    {
        //
    }
}

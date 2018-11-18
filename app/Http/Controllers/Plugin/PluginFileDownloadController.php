<?php

namespace App\Http\Controllers\Plugin;

use App\Models\Plugin;
use App\Models\PluginFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PluginFileDownloadController extends Controller
{
    /**
     * Download the specified plugin file.
     *
     * @param  \App\Models\Plugin $plugin
     * @param  \App\Models\PluginFile $pluginFile
     * @return \DownloadResponse
     */
    public function show(Plugin $plugin, PluginFile $pluginFile)
    {
        $file = Storage::disk(config('pluginchest.storage.validated'))
                ->download($pluginFile->file_name, studly_case($plugin->name) . '.jar');

        return $file;
    }
}

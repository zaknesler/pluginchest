<?php

namespace App\Http\Controllers\Plugin\File;

use Storage;
use App\Plugin;
use App\PluginFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Plugins\Files\IncrementDownloadsCount;

class PluginFileDownloadController extends Controller
{
    /**
     * Download the file.
     *
     * @param  App\Plugin  $plugin
     * @param  App\PluginFile  $pluginFile
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Plugin $plugin, PluginFile $pluginFile)
    {
        $file = Storage::disk('s3-plugin-files')->get($pluginFile->file);

        $response = response($file, 200, [
            'Content-Type' => 'application/java-archive',
            'Content-Length' => $pluginFile->file_size,
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment; filename=' . studly_case($plugin->name) . '.jar',
            'Content-Transfer-Encoding' => 'binary',
        ]);

        ob_end_clean();

        $this->dispatch(new IncrementDownloadsCount($pluginFile));

        return $response;
    }
}

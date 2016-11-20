<?php

namespace App\Jobs\Plugins\Files;

use File;
use Storage;
use App\PluginFile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StorePluginFile implements ShouldQueue
{
    public $pluginFile;

    public $fileId;

    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PluginFile $pluginFile, $fileId)
    {
        $this->pluginFile = $pluginFile;

        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fileName = $this->fileId . '.jar';
        $filePath = storage_path() . '\\local-plugin-files\\' . $this->fileId;

        if (Storage::disk('s3-plugin-files')->put($fileName, $handle = fopen($filePath, 'r+'))) {
            fclose($handle);

            File::delete($filePath);
        }

        $this->pluginFile->file = $fileName;
        $this->pluginFile->save();
    }
}

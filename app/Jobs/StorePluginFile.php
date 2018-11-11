<?php

namespace App\Jobs;

use App\Models\PluginFile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class StorePluginFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Plugin file model.
     *
     * @var App\Models\PluginFile
     */
    protected $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PluginFile $file)
    {
        $this->file = $file;
    }

    /**
     * Get the full path to the directory of the plugin file.
     *
     * @return string
     */
    private function getWorkingDirectory()
    {
        return Storage::disk(config('pluginchest.storage.temporary'))->path($this->file->temporary_file);
    }

    /**
     * Get the full path to the plugin file.
     *
     * @return string
     */
    private function getFileFullPath()
    {
        return join(DIRECTORY_SEPARATOR, [$this->getWorkingDirectory(), $this->file->temporary_file]);
    }

    /**
     * Delete temporary directory.
     *
     * @return void
     */
    private function cleanUp()
    {
        Storage::disk(config('pluginchest.storage.temporary'))->deleteDirectory($this->file->temporary_file);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $name = str_random(16);

        Storage::disk(config('pluginchest.storage.validated'))->put($name, file_get_contents($this->getFileFullPath()));

        $this->file->update([
            'file_name' => $name,
            'file_size' => filesize($this->getFileFullPath()),
            'temporary_file' => null,
        ]);

        $this->cleanUp();
    }
}

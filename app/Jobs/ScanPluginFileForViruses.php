<?php

namespace App\Jobs;

use App\Models\PluginFile;
use Illuminate\Support\Str;
use App\Jobs\StorePluginFile;
use App\Scanners\FileScanner;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ScanPluginFileForViruses implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Plugin file model.
     *
     * @var App\Models\PluginFile
     */
    protected $file;

    /**
     * List of validation errors discovered.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $errors;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\PluginFile $file
     * @return void
     */
    public function __construct(PluginFile $file)
    {
        $this->file = $file;

        $this->errors = collect();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = app(FileScanner::class)->scan($this->getFileFullPath());

        if ($result->positives > 0) {
            $this->errors->push(
                "Virus scan returned {$result->positives} of {$result->total} " . Str::plural('positives', $result->positives) . '.'
            );
        }

        $this->file->addValidationErrors($this->errors);
    }

    /**
     * Get the full path to the directory of the plugin file.
     *
     * @return string
     */
    private function getFileDirectoryPath()
    {
        return Storage::disk(config('pluginchest.storage.temporary'))
                      ->path($this->file->temporary_file);
    }

    /**
     * Get the full path to the plugin file.
     *
     * @return string
     */
    private function getFileFullPath()
    {
        return join(DIRECTORY_SEPARATOR, [
            $this->getFileDirectoryPath(),
            $this->file->temporary_file
        ]);
    }
}

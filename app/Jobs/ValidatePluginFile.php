<?php

namespace App\Jobs;

use App\Models\PluginFile;
use App\Jobs\StorePluginFile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Exceptions\Plugin\File\InvalidTemporaryFile;

class ValidatePluginFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Plugin file model.
     *
     * @var App\Models\PluginFile
     */
    protected $file

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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (is_null($file->temporary_file)) {
            throw new InvalidTemporaryFile;
        }

        // unzip .jar
        // verify that plugin.yml exists
        // ensure that the name, version, and main settings exist
        // match "main" location from plugin.yml with directories (maybe)
        // set verified_at to current timestamp
    }
}

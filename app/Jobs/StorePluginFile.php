<?php

namespace App\Jobs;

use App\Models\PluginFile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Exceptions\Plugin\File\InvalidTemporaryFile;

class StorePluginFile implements ShouldQueue
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

        // create name for plugin
        // move temporary file to disk
        // delete demporary file
        // save file size to database
    }
}

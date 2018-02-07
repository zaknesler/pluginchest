<?php

namespace App\Jobs;

use App\Models\PluginFile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
     * Name of temporarily uploaded file.
     *
     * @var string
     */
    protected $name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PluginFile $file, string $name)
    {
        $this->file = $file;

        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // unzip .jar
        // verify that plugin.yml exists
        // ensure that the name, version, author, description, and main settings exist
        // match "main" location from plugin.yml with directories (maybe)
    }
}

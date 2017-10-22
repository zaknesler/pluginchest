<?php

namespace App\Jobs\Plugins\Files;

use Storage;
use App\PluginFile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeletePluginFile implements ShouldQueue
{
    public $pluginFile;

    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PluginFile $pluginFile)
    {
        $this->pluginFile = $pluginFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Storage::disk('prod-plugin-files')->delete($this->pluginFile->file);

        $this->pluginFile->delete();
    }
}

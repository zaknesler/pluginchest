<?php

namespace App\Jobs\Plugins\Files;

use App\PluginFile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncrementDownloadsCount implements ShouldQueue
{
    protected $pluginFile;

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
        $this->pluginFile->increment('downloads_count');
    }
}

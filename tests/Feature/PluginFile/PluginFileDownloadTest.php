<?php

namespace Tests\Feature\PluginFile;

use Tests\TestCase;
use App\Models\Plugin;
use App\Models\PluginFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PluginFileDownloadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function plugin_file_can_be_downloaded_and_can_increment_total_downloads_count()
    {
        $plugin = factory(Plugin::class)->create(['name' => 'Test Plugin']);
        $plugin->users()->attach($this->authenticate(), ['role' => 'owner']);

        $this->post(route('plugins.files.store', [$plugin->slug, $plugin->id]), [
            'name' => 'Test Plugin File',
            'description' => 'This is a test plugin file.',
            'stage' => 'release',
            'game_version' => '1.12.2',
            'plugin_file' => $this->getValidPluginFile(),
        ]);

        $pluginFile = PluginFile::first();

        $response = $this->get($pluginFile->getDownloadLink());

        $response->assertHeader('content-disposition', 'attachment; filename=TestPlugin.jar');
        $response->assertSuccessful();
    }
}

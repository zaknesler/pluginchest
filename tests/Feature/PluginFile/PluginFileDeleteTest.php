<?php

namespace Tests\Feature\PluginFile;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plugin;
use App\Models\PluginFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PluginFileDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function plugin_file_can_be_deleted()
    {
        Storage::fake(config('pluginchest.storage.temporary'));
        Storage::fake(config('pluginchest.storage.validated'));

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

        $response = $this->delete(route('plugins.files.destroy', [$plugin->slug, $plugin->id, $pluginFile->id]));

        $response->assertRedirect($plugin->getUrl());
        $this->assertEquals(0, PluginFile::count());
        $this->assertEmpty(Storage::disk(config('pluginchest.storage.validated'))->files());
    }

    /** @test */
    function user_must_have_permission_to_delete_plugin_file()
    {
        Storage::fake(config('pluginchest.storage.temporary'));
        Storage::fake(config('pluginchest.storage.validated'));

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

        $this->authenticate();
        $response = $this->delete(route('plugins.files.destroy', [$plugin->slug, $plugin->id, $pluginFile->id]));

        $response->assertStatus(403);
        $this->assertEquals(1, PluginFile::count());
        $this->assertNotEmpty(Storage::disk(config('pluginchest.storage.validated'))->files());
    }

    /** @test */
    function guests_cannot_delete_plugin_files()
    {
        Storage::fake(config('pluginchest.storage.temporary'));
        Storage::fake(config('pluginchest.storage.validated'));

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

        auth()->logout();
        $response = $this->delete(route('plugins.files.destroy', [$plugin->slug, $plugin->id, $pluginFile->id]));

        $response->assertRedirect(route('login'));
        $this->assertEquals(1, PluginFile::count());
        $this->assertNotEmpty(Storage::disk(config('pluginchest.storage.validated'))->files());
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plugin;
use App\Models\PluginFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PluginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_plugin_slug_is_created_from_its_name()
    {
        $plugin = Plugin::create([
            'name' => 'Test Plugin',
            'description' => 'Some long description.',
        ]);

        $this->assertEquals('test-plugin', $plugin->slug);
    }

    /** @test */
    function a_plugin_can_have_many_users_with_different_roles()
    {
        $plugin = factory(Plugin::class)->create();
        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();

        $plugin->users()->attach($userA, ['role' => 'owner']);
        $plugin->users()->attach($userB, ['role' => 'author']);

        $this->assertEquals(2, $plugin->users()->count());
        $this->assertEquals('owner', $plugin->users()->find(1)->pivot->role);
        $this->assertEquals('author', $plugin->users()->find(2)->pivot->role);
    }

    /** @test */
    function a_plugin_can_have_many_files()
    {
        $plugin = factory(Plugin::class)->create();

        factory(PluginFile::class, 3)->create(['plugin_id' => 1]);

        $this->assertEquals(3, $plugin->files()->count());
    }

    /** @test */
    function plugin_can_sum_total_downloads_for_associated_files()
    {
        $plugin = factory(Plugin::class)->create();
        $pluginFileA = factory(PluginFile::class)->create(['plugin_id' => 1, 'downloads_count' => 30]);
        $pluginFileB = factory(PluginFile::class)->create(['plugin_id' => 1, 'downloads_count' => 12]);

        $this->assertEquals(42, $plugin->total_downloads_count);
    }
}

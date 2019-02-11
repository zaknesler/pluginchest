<?php

namespace Tests\Feature\PluginFile;

use Tests\TestCase;
use App\Models\Plugin;
use App\Models\PluginFile;
use App\Jobs\StorePluginFile;
use App\Jobs\ValidatePluginFile;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ScanPluginFileForViruses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PluginFileCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function plugin_file_create_form_can_only_be_viewed_by_user_with_owner_role()
    {
        $plugin = factory(Plugin::class)->create();
        $plugin->users()->attach($this->authenticate(), ['role' => 'owner']);

        $response = $this->get(route('plugins.files.create', [$plugin->slug, $plugin->id]));

        $response->assertSuccessful();
        $response->assertViewIs('plugins.files.create');
    }

    /** @test */
    function plugin_file_create_form_can_only_be_viewed_by_user_with_author_role()
    {
        $plugin = factory(Plugin::class)->create();
        $plugin->users()->attach($this->authenticate(), ['role' => 'author']);

        $response = $this->get(route('plugins.files.create', [$plugin->slug, $plugin->id]));

        $response->assertSuccessful();
        $response->assertViewIs('plugins.files.create');
    }

     /** @test */
    function plugin_file_create_form_cannot_be_viewed_by_a_guest()
    {
        $plugin = factory(Plugin::class)->create();

        $response = $this->get(route('plugins.files.create', [$plugin->slug, $plugin->id]));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    function valid_file_can_be_validated_and_stored()
    {
        $plugin = factory(Plugin::class)->create();
        $plugin->users()->attach($user = $this->authenticate(), ['role' => 'owner']);

        $response = $this->post(route('plugins.files.store', [$plugin->slug, $plugin->id]), [
            'name' => 'Test Plugin File',
            'description' => 'This is a test plugin file.',
            'stage' => 'release',
            'game_version' => '1.12.2',
            'plugin_file' => $this->getValidPluginFile(),
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertNotNull($pluginFile = PluginFile::first());
        $this->assertNull($pluginFile->validation_errors);
        $this->assertNotNull($pluginFile->validated_at);
        $this->assertNotNull($pluginFile->file_name);
        $this->assertNotNull($pluginFile->file_size);
        $this->assertTrue(Storage::disk(config('pluginchest.storage.validated'))->has($pluginFile->file_name));
        $this->assertEmpty(Storage::disk(config('pluginchest.storage.temporary'))->files());
    }

    /** @test */
    function plugin_file_uploading_triggers_queue_jobs()
    {
        Queue::fake();

        $plugin = factory(Plugin::class)->create();
        $plugin->users()->attach($user = $this->authenticate(), ['role' => 'owner']);

        $response = $this->post(route('plugins.files.store', [$plugin->slug, $plugin->id]), [
            'name' => 'Test Plugin File',
            'description' => 'This is a test plugin file.',
            'stage' => 'release',
            'game_version' => '1.12.2',
            'plugin_file' => $this->getValidPluginFile(),
        ]);

        Queue::assertPushedWithChain(ScanPluginFileForViruses::class, [
            ValidatePluginFile::class,
            StorePluginFile::class,
        ]);
    }

    /** @test */
    function file_with_invalid_yml_file_is_not_validated_but_is_still_stored()
    {
        $plugin = factory(Plugin::class)->create();
        $plugin->users()->attach($user = $this->authenticate(), ['role' => 'owner']);

        $response = $this->post(route('plugins.files.store', [$plugin->slug, $plugin->id]), [
            'name' => 'Test Plugin File',
            'description' => 'This is a test plugin file.',
            'stage' => 'release',
            'game_version' => '1.12.2',
            'plugin_file' => $this->getInvalidPluginFile(),
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertNotNull($pluginFile = PluginFile::first());
        $this->assertNotNull($pluginFile->validation_errors);
        $this->assertNotNull($pluginFile->validated_at);
        $this->assertNotNull($pluginFile->file_name);
        $this->assertNotNull($pluginFile->file_size);
        $this->assertTrue(Storage::disk(config('pluginchest.storage.validated'))->has($pluginFile->file_name));
        $this->assertEmpty(Storage::disk(config('pluginchest.storage.temporary'))->files());
    }

     /** @test */
    function user_must_be_authenticated_to_create_a_plugin_file()
    {
        $response = $this->post(route('plugins.store'), [
            'name' => 'Test Plugin File',
            'description' => 'This is a test plugin file.',
            'stage' => 'release',
            'game_version' => '1.12.2',
            'plugin_file' => $this->getValidPluginFile(),
        ]);

        $response->assertRedirect(route('login'));
        $this->assertEquals(0, PluginFile::count());
    }

    /** @test */
    function plugin_file_must_have_a_valid_name()
    {
        $plugin = factory(Plugin::class)->create(['name' => 'Test Plugin']);
        $plugin->users()->attach($this->authenticate(), ['role' => 'owner']);

        $response = $this->post(route('plugins.files.store', [$plugin->slug, $plugin->id]), [
            'name' => '',
            'description' => 'This is a test plugin file.',
            'stage' => 'release',
            'game_version' => '1.12.2',
            'plugin_file' => $this->getValidPluginFile(),
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertEquals(0, PluginFile::count());
    }

    /** @test */
    function plugin_file_must_have_a_valid_description()
    {
        $plugin = factory(Plugin::class)->create(['name' => 'Test Plugin']);
        $plugin->users()->attach($this->authenticate(), ['role' => 'owner']);

        $response = $this->post(route('plugins.files.store', [$plugin->slug, $plugin->id]), [
            'name' => 'Valid name',
            'description' => 'Too short',
            'stage' => 'release',
            'game_version' => '1.12.2',
            'plugin_file' => $this->getValidPluginFile(),
        ]);

        $response->assertSessionHasErrors('description');
        $this->assertEquals(0, PluginFile::count());
    }

    /** @test */
    function plugin_file_must_have_a_valid_file_stage()
    {
        $plugin = factory(Plugin::class)->create(['name' => 'Test Plugin']);
        $plugin->users()->attach($this->authenticate(), ['role' => 'owner']);

        $response = $this->post(route('plugins.files.store', [$plugin->slug, $plugin->id]), [
            'name' => 'Valid name',
            'description' => 'Too short',
            'stage' => 'invalid',
            'game_version' => '1.12.2',
            'plugin_file' => $this->getValidPluginFile(),
        ]);

        $response->assertSessionHasErrors('stage');
        $this->assertEquals(0, PluginFile::count());
    }

    /** @test */
    function plugin_file_must_have_a_valid_game_version()
    {
        $plugin = factory(Plugin::class)->create(['name' => 'Test Plugin']);
        $plugin->users()->attach($this->authenticate(), ['role' => 'owner']);

        $response = $this->post(route('plugins.files.store', [$plugin->slug, $plugin->id]), [
            'name' => 'Valid name',
            'description' => 'Too short',
            'stage' => 'release',
            'game_version' => 'invalid',
            'plugin_file' => $this->getValidPluginFile(),
        ]);

        $response->assertSessionHasErrors('game_version');
        $this->assertEquals(0, PluginFile::count());
    }

    /** @test */
    function plugin_file_must_have_a_valid_file()
    {
        $plugin = factory(Plugin::class)->create(['name' => 'Test Plugin']);
        $plugin->users()->attach($this->authenticate(), ['role' => 'owner']);

        $response = $this->post(route('plugins.files.store', [$plugin->slug, $plugin->id]), [
            'name' => 'Valid name',
            'description' => 'Too short',
            'stage' => 'release',
            'game_version' => '1.12.2',
            'plugin_file' => null,
        ]);

        $response->assertSessionHasErrors('plugin_file');
        $this->assertEquals(0, PluginFile::count());
    }
}

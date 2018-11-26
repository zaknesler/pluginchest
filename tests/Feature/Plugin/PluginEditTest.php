<?php

namespace Tests\Feature\Plugin;

use Tests\TestCase;
use App\Models\Plugin;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PluginEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function plugin_edit_form_can_be_viewed_by_owner()
    {
        $plugin = factory(Plugin::class)->create();
        $plugin->users()->attach($user = $this->authenticate(), ['role' => 'owner']);

        $response = $this->get(route('plugins.edit', [$plugin->slug, $plugin->id]));

        $response->assertSuccessful();
        $response->assertViewIs('plugins.edit');
    }

    /** @test */
    function plugin_edit_form_can_be_viewed_by_author()
    {
        $plugin = factory(Plugin::class)->create();
        $plugin->users()->attach($user = $this->authenticate(), ['role' => 'author']);

        $response = $this->get(route('plugins.edit', [$plugin->slug, $plugin->id]));

        $response->assertSuccessful();
        $response->assertViewIs('plugins.edit');
    }

    /** @test */
    function plugin_edit_form_cannot_be_viewed_by_unassociated_user()
    {
        $plugin = factory(Plugin::class)->create();
        $this->authenticate();

        $response = $this->get(route('plugins.edit', [$plugin->slug, $plugin->id]));

        $response->assertStatus(403);
    }

    /** @test */
    function plugin_edit_form_cannot_be_viewed_by_guest()
    {
        $plugin = factory(Plugin::class)->create();

        $response = $this->get(route('plugins.edit', [$plugin->slug, $plugin->id]));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    function plugin_can_be_edited_by_owner()
    {
        $plugin = factory(Plugin::class)->create();
        $plugin->users()->attach($user = $this->authenticate(), ['role' => 'owner']);

        $response = $this->patch(route('plugins.update', [$plugin->slug, $plugin->id]), [
            'name' => 'Updated Plugin Name',
            'description' => 'An updated plugin description.'
        ]);

        $response->assertRedirect(route('plugins.show', [$plugin->slug, $plugin->id]));
        $this->assertEquals('Updated Plugin Name', Plugin::first()->name);
        $this->assertEquals('An updated plugin description.', Plugin::first()->description);
    }
}

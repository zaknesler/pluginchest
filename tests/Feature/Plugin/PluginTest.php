<?php

namespace Tests\Feature\Plugin;

use Tests\TestCase;
use App\Models\Plugin;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PluginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_plugin_can_be_created()
    {
        $this->authenticate();

        $response = $this->post(route('plugins.store'), [
            'name' => 'Test Plugin',
            'description' => 'This is just a test plugin whose description is long.',
        ]);

        $plugin = Plugin::first();

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('plugins.show', [$plugin->slug, $plugin->id]));
        $this->assertEquals(1, Plugin::count());
        $this->assertEquals(1, $plugin->users()->count());
        $this->assertNotNull($plugin->slug);
        $this->assertTrue($plugin->users()->first()->pivot->hasRole('owner'));
    }

    /** @test */
    function user_must_be_authenticated_to_create_a_plugin()
    {
        $response = $this->post(route('plugins.store'), [
            'name' => 'Test Plugin',
            'description' => 'This is just a test plugin whose description is long.',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertEquals(0, Plugin::count());
    }

    /** @test */
    function a_plugin_must_have_a_valid_name()
    {
        $this->authenticate();

        $response = $this->post(route('plugins.store'), [
            'name' => 'Nope',
            'description' => 'This is just a test plugin whose description is long.',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertEquals(0, Plugin::count());
    }

    /** @test */
    function a_plugin_must_have_a_valid_description()
    {
        $this->authenticate();

        $response = $this->post(route('plugins.store'), [
            'name' => 'Test Plugin',
            'description' => 'Too short.',
        ]);

        $response->assertSessionHasErrors('description');
        $this->assertEquals(0, Plugin::count());
    }

    /** @test */
    function plugin_create_form_can_be_viewed_by_authenticated_user()
    {
        $this->authenticate();

        $response = $this->get(route('plugins.create'));

        $response->assertSuccessful();
        $response->assertViewIs('plugins.create');
    }

    /** @test */
    function plugin_create_form_cannot_be_viewed_by_guest()
    {
        $response = $this->get(route('plugins.create'));

        $response->assertRedirect(route('login'));
    }

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

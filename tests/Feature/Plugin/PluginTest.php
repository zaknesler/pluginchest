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
            'name' => 'TestPlugin',
            'description' => 'This is just a test plugin whose description is long.',
        ]);

        $plugin = Plugin::first();

        $response->assertRedirect(route('plugins.show', [$plugin->slug, $plugin->id]));
        $this->assertEquals(1, Plugin::count());
        $this->assertEquals(1, $plugin->users()->count());
        $this->assertNotNull($plugin->slug);
        $this->assertTrue($plugin->users()->first()->pivot->hasRole('owner'));
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
            'name' => 'TestPlugin',
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
}

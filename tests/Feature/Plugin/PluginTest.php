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

        $response->assertRedirect(route('plugins.show', Plugin::first()));
        $this->assertEquals(1, Plugin::count());
        $this->assertEquals(1, Plugin::first()->users()->count());
        $this->assertNotNull(Plugin::first()->slug);
        $this->assertTrue(Plugin::first()->users()->first()->pivot->is_creator);
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
}

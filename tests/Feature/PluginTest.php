<?php

namespace Tests\Feature;

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
            'description' => 'This is just a test plugin.',
        ]);

        $response->assertRedirect(route('plugins.show', Plugin::first()));
        $this->assertEquals(1, Plugin::count());
        $this->assertEquals(1, Plugin::first()->users()->count());
        $this->assertTrue(Plugin::first()->users()->first()->pivot->is_creator);
    }
}

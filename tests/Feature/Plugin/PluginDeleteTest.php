<?php

namespace Tests\Feature\Plugin;

use Tests\TestCase;
use App\Models\Plugin;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PluginDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function plugin_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $plugin = factory(Plugin::class)->create();
        $plugin->users()->attach($user = $this->authenticate(), ['role' => 'owner']);

        $response = $this->delete(route('plugins.destroy', [$plugin->slug, $plugin->id]));

        $response->assertSuccessful();
        $this->assertEquals(0, Plugin::count());
    }
}

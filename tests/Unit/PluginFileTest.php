<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\PluginFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PluginFileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_plugin_file_can_return_a_formatted_file_size()
    {
        $pluginFileA = factory(PluginFile::class)->create(['file_size' => 3145728]);
        $pluginFileB = factory(PluginFile::class)->create(['file_size' => 30720]);

        $this->assertEquals('3.0 MB', $pluginFileA->getFileSize());
        $this->assertEquals('30.0 KB', $pluginFileB->getFileSize());
    }
}

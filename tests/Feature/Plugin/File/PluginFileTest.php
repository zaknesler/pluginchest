<?php

namespace Tests\Feature\Plugin\File;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PluginFileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function valid_file_can_be_uploaded()
    {
        // create plugin
        // send request with valid plugin file
        // assert that file was verified and stored. (ensure jobs were fired)
    }
}

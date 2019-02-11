<?php

namespace Tests;

use App\Models\User;
use App\Scanners\FileScanner;
use App\Scanners\FakeFileScanner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();

        Storage::fake(config('pluginchest.storage.temporary'));
        Storage::fake(config('pluginchest.storage.validated'));

        $this->app->bind(FileScanner::class, FakeFileScanner::class);
    }

    /**
     * Authenticate as a specified or generated user.
     *
     * @param  \App\Models\User|null $user
     * @param  array $overrides
     * @return \App\Models\User
     */
    protected function authenticate(User $user = null, array $overrides = []) : User
    {
        $this->be($user ?: $user = factory(User::class)->create($overrides));

        return $user;
    }

    /**
     * Get a valid uploaded file.
     *
     * @return \Illuminate\Http\UploadedFile
     */
    public function getValidPluginFile()
    {
        $path = base_path('tests/stubs/Plugin/File/ValidPluginFile.jar');

        return new UploadedFile($path, 'ValidPluginFile.jar', filesize($path), null, true);
    }

    /**
     * Get an invalid uploaded file.
     *
     * @return \Illuminate\Http\UploadedFile
     */
    public function getInvalidPluginFile()
    {
        $path = base_path('tests/stubs/Plugin/File/InvalidPluginFile.jar');

        return new UploadedFile($path, 'InvalidPluginFile.jar', filesize($path), null, true);
    }
}

<?php

namespace Tests;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

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

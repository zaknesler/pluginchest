<?php

namespace App\Verification;

use Illuminate\Http\UploadedFile;

interface FileVerifier
{
    /**
     * Verify a specified file.
     *
     * @param  string  $file
     * @return void
     */
    public function verify($path);
}

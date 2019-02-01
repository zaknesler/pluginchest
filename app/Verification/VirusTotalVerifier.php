<?php

namespace App\Verification;

use Daniesy\VirusScanner\Facades\VirusScanner;

class VirusTotalVerifier implements FileVerifier
{
    /**
     * Verify a specified file.
     *
     * @param  string  $file
     * @return void
     */
    public function verify($path)
    {
        $response = VirusScanner::scanFile($path)->checkResult();

        dd($response);
    }
}

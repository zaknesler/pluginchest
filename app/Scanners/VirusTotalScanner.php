<?php

namespace App\Scanners;

use Daniesy\VirusScanner\VirusScanner;

class VirusTotalScanner implements FileScanner
{
    /**
     * Scan a file for viruses.
     *
     * @param  string  path
     * @return self
     */
    public function scan(string $path)
    {
        $result = (new VirusScanner)->scanFile($path)->checkResult();

        if ($result) {
            return new ScanResult(
                $result->positives,
                $result->total,
                $result->scans
            );
        }
    }
}

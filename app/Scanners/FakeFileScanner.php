<?php

namespace App\Scanners;

class FakeFileScanner implements FileScanner
{
    /**
     * Scan a file for viruses.
     *
     * @param  string  path
     * @return self
     */
    public function scan(string $path)
    {
        return new ScanResult(
            0,
            2,
            [
                ['message' => 'This is a fake scan result.'],
                ['message' => 'This is another fake scan result.'],
            ]
        );
    }
}

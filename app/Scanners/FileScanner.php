<?php

namespace App\Scanners;

interface FileScanner
{
    /**
     * Scan a file for viruses.
     *
     * @param  string path
     * @return \App\Scanners\ScanResult
     */
    public function scan(string $path);
}

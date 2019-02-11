<?php

namespace App\Scanners;

class ScanResult
{
    /**
     * Number of positive virus scans.
     *
     * @var int
     */
    public $positives;

    /**
     * Total number of scans performed.
     *
     * @var int
     */
    public $totalScans;

    /**
     * Array of all scans performed.
     *
     * @var array
     */
    public $scans;

    /**
     * Create new scan result.
     *
     * @param int  $positives
     * @param int  $totalScans
     * @param array  $scans
     */
    public function __construct($positives, $totalScans, $scans)
    {
        $this->positives = $positives;
        $this->totalScans = $totalScans;
        $this->scans = $scans;
    }
}

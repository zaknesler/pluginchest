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
    public $total;

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
     * @param int  $total
     * @param array  $scans
     */
    public function __construct($positives, $total, $scans)
    {
        $this->positives = $positives;
        $this->total = $total;
        $this->scans = $scans;
    }
}

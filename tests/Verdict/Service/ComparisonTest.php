<?php

namespace Tests\Verdict\Service;

require_once('../../autoloader.php');

use Verdict\Service\Comparison\Discover,
    PHPUnit_Framework_TestCase;

class ComparisonTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test our comparison discover service - toJson
     * @return void
     */
    public function testComparisonDiscoverToJson()
    {
        $discover = new Discover();
        $comparisonData = $discover->toJson();
        $this->assertTrue(is_array($comparisonData));
        $this->assertArrayHasKey('equals', $comparisonData);
    }
}

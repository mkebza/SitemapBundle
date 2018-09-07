<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Sitemap\Tests\Service;

use MKebza\Sitemap\Enum\ChangeFrequency;
use MKebza\Sitemap\Service\Location;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testGetters()
    {
        $date = new \DateTime();
        $location = new Location('test_url', $date, ChangeFrequency::WEEKLY(), 0.7);

        $this->assertSame('test_url', $location->getLocation());
        $this->assertSame($date, $location->getLastModification());
        $this->assertSame(ChangeFrequency::WEEKLY(), $location->getChangeFrequency());
        $this->assertSame(0.7, $location->getPriority());
    }

    public function testInvalidPriority()
    {
        $this->expectException(\OutOfRangeException::class);
        $location = new Location('test_url', null, null, 1.5);

        $this->expectException(\OutOfRangeException::class);
        $location = new Location('test_url', null, null, -0.1);
    }
}

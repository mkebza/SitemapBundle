<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Sitemap\Tests\Service;

use MKebza\Sitemap\Service\Location;
use MKebza\Sitemap\Service\LocationCollector;
use MKebza\Sitemap\Service\SitemapLocationGeneratorInterface;
use PHPUnit\Framework\TestCase;

class LocationCollectorTest extends TestCase
{
    public function testGenerate()
    {
        $locations = [
            new Location('test_url_1'),
            new Location('test_url_2'),
            new Location('test_url_3'),
        ];

        $generator = $this->createMock(SitemapLocationGeneratorInterface::class);
        $generator
            ->expects($this->exactly(1))
            ->method('generate')
            ->will($this->returnCallback(function () use ($locations) {
                foreach ($locations as $location) {
                    yield $location;
                }
            }));

        $collector = new LocationCollector([$generator]);

        foreach ($collector->generate() as $i => $value) {
            $this->assertSame($locations[$i], $value);
        }
        $this->assertSame(2, $i);
    }

    public function testGenerateInvalidObject()
    {
        $locations = [
            new \stdClass(),
        ];

        $generatorMock = $this->createMock(SitemapLocationGeneratorInterface::class);
        $generatorMock
            ->method('generate')
            ->will($this->returnCallback(function () use ($locations) {
                foreach ($locations as $location) {
                    yield $location;
                }
            }));

        $collector = new LocationCollector([$generatorMock]);

        $this->expectException(\InvalidArgumentException::class);
        foreach ($collector->generate() as $item) {
        }
    }
}

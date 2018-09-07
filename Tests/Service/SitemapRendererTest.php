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
use MKebza\Sitemap\Service\LocationRenderer;
use MKebza\Sitemap\Service\SitemapRenderer;
use PHPUnit\Framework\TestCase;

class SitemapRendererTest extends TestCase
{
    public function testRender()
    {
        $collectorMock = $this->createMock(LocationCollector::class);
        $collectorMock
            ->expects($this->once())
            ->method('generate')
            ->will($this->returnCallback(function () {
                $map = [new Location('first'), new Location('second')];
                foreach ($map as $item) {
                    yield $item;
                }
            }));

        $sitemap = new SitemapRenderer($collectorMock, new LocationRenderer('https://example.com'));
        $output = $sitemap->render();

        $xml = simplexml_load_string($output);

        $this->assertNotFalse($xml);
        $this->assertInstanceOf(\SimpleXMLElement::class, $xml);
        $this->assertSame('https://example.com/first', (string) $xml->url[0]->loc);
        $this->assertSame('https://example.com/second', (string) $xml->url[1]->loc);
    }
}

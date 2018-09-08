<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Sitemap\Tests\Service;

use MKebza\Sitemap\Enum\ChangeFrequency;
use MKebza\Sitemap\Service\Location;
use MKebza\Sitemap\Service\LocationRenderer;
use PHPUnit\Framework\TestCase;

class LocationRendererTest extends TestCase
{
    public function testRenderBasic()
    {
        $writer = $this->getWriter();
        $location = new Location('test_url');

        $renderer = new LocationRenderer(null);
        $renderer->render($location, $writer);

        $xml = simplexml_load_string($writer->outputMemory());

        $this->assertNotFalse($xml);
        $this->assertInstanceOf(\SimpleXMLElement::class, $xml);
        $this->assertSame('test_url', (string) $xml->loc);
        $this->assertSame(0.5, (float) $xml->priority);
    }

    public function testRenderFull()
    {
        $writer = $this->getWriter();

        $date = new \DateTime();
        $location = new Location('test_url', $date, ChangeFrequency::YEARLY(), 0.7);

        $renderer = new LocationRenderer(null);
        $renderer->render($location, $writer);

        $xml = simplexml_load_string($writer->outputMemory());

        $this->assertNotFalse($xml);
        $this->assertInstanceOf(\SimpleXMLElement::class, $xml);
        $this->assertSame('test_url', (string) $xml->loc);
        $this->assertSame($date->format('Y-m-dTH:i'), (string) $xml->lastmod);
        $this->assertSame(ChangeFrequency::YEARLY()->getValue(), (string) $xml->changefreq);
        $this->assertSame(0.7, (float) $xml->priority);
    }

    public function testDefaultUrlPrefix()
    {
        $writer = $this->getWriter();
        $location = new Location('test_url');

        $renderer = new LocationRenderer('http://example.com/');
        $renderer->render($location, $writer);

        $xml = simplexml_load_string($writer->outputMemory());

        $this->assertNotFalse($xml);
        $this->assertInstanceOf(\SimpleXMLElement::class, $xml);
        $this->assertSame('http://example.com/test_url', (string) $xml->loc);
    }

    public function testDefaultUrlPrefixKeepUrlHttp()
    {
        $writer = $this->getWriter();
        $location = new Location('http://foo.bar/test_url');

        $renderer = new LocationRenderer('http://example.com/');
        $renderer->render($location, $writer);

        $xml = simplexml_load_string($writer->outputMemory());

        $this->assertNotFalse($xml);
        $this->assertInstanceOf(\SimpleXMLElement::class, $xml);
        $this->assertSame('http://foo.bar/test_url', (string) $xml->loc);
    }

    public function testDefaultUrlPrefixKeepUrlHttps()
    {
        $writer = $this->getWriter();
        $location = new Location('https://foo.bar/test_url');

        $renderer = new LocationRenderer('http://example.com/');
        $renderer->render($location, $writer);

        $xml = simplexml_load_string($writer->outputMemory());

        $this->assertNotFalse($xml);
        $this->assertInstanceOf(\SimpleXMLElement::class, $xml);
        $this->assertSame('https://foo.bar/test_url', (string) $xml->loc);
    }

    public function testDefaultUrlPrefixDoubleSlashes()
    {
        $writer = $this->getWriter();
        $location = new Location('/test_url');

        $renderer = new LocationRenderer('http://example.com/');
        $renderer->render($location, $writer);

        $xml = simplexml_load_string($writer->outputMemory());

        $this->assertNotFalse($xml);
        $this->assertInstanceOf(\SimpleXMLElement::class, $xml);
        $this->assertSame('http://example.com/test_url', (string) $xml->loc);
    }

    private function getWriter(): \XMLWriter
    {
        $writer = new \XMLWriter();
        $writer->openMemory();

        return $writer;
    }
}

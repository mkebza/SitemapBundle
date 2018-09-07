<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Sitemap\Service;

class SitemapRenderer
{
    /**
     * @var LocationCollector
     */
    private $collector;

    /**
     * @var LocationRenderer
     */
    private $locationRenderer;

    /**
     * SitemapRenderer constructor.
     *
     * @param LocationCollector $collector
     * @param LocationRenderer  $locationRenderer
     */
    public function __construct(LocationCollector $collector, LocationRenderer $locationRenderer)
    {
        $this->collector = $collector;
        $this->locationRenderer = $locationRenderer;
    }

    public function render()
    {
        $writer = $this->createXmlWriter();

        $writer->startElement('urlset');
        $writer->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($this->collector->generate() as $location) {
            $this->locationRenderer->render($location, $writer);
        }
        $writer->endElement();

        return $writer->outputMemory(true);
    }

    protected function createXmlWriter(): \XMLWriter
    {
        $writer = new \XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->setIndent(true);
        $writer->setIndentString(' ');

        return $writer;
    }
}

<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Sitemap\Service;

class LocationRenderer
{
    /**
     * @var null|string
     */
    private $baseUrl;

    /**
     * LocationRenderer constructor.
     *
     * @param null|string $baseUrl
     */
    public function __construct(?string $baseUrl)
    {
        $this->baseUrl = null;
        if (null !== $baseUrl) {
            $this->baseUrl = rtrim($baseUrl, '/');
        }
    }

    public function render(Location $location, \XMLWriter $writer)
    {
        $writer->startElement('url');
        $writer->writeElement('loc', $this->getUrl($location->getLocation()));

        if (null !== $location->getLastModification()) {
            $writer->writeElement('lastmod', $location->getLastModification()->format('Y-m-d\TH:i:sP'));
        }

        if (null !== $location->getPriority()) {
            $writer->writeElement('priority', (string) $location->getPriority());
        }

        if (null !== $location->getChangeFrequency()) {
            $writer->writeElement('changefreq', (string) $location->getChangeFrequency()->getValue());
        }
        $writer->endElement();
    }

    private function getUrl(string $url): string
    {
        if (null === $this->baseUrl) {
            return $url;
        }

        if (0 === \strpos($url, 'https://') || 0 === \strpos($url, 'http://')) {
            return $url;
        }

        return $this->baseUrl.'/'.ltrim($url, '/');
    }
}

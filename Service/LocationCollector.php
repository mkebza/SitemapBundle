<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Sitemap\Service;

class LocationCollector
{
    /**
     * @var iterable|SitemapLocationGeneratorInterface[]
     */
    private $generators;

    /**
     * LocationCollector constructor.
     */
    public function __construct(iterable $generators)
    {
        $this->generators = $generators;
    }

    public function generate()
    {
        foreach ($this->generators as $generator) {
            foreach ($generator->generate() as $item) {
                if ($item instanceof Location) {
                    yield $item;
                } else {
                    throw new \InvalidArgumentException(sprintf(
                        '%s::generate() must always return instance of %s, instace of %s returned',
                        SitemapLocationGeneratorInterface::class,
                        Location::class,
                        (is_object($item) ? get_class($item) : gettype($item))
                    ));
                }
            }
        }
    }
}

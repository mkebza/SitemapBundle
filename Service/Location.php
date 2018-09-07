<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Sitemap\Service;

use MKebza\Sitemap\Enum\ChangeFrequency;

class Location
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var null|\DateTime
     */
    private $lastModification;

    /**
     * @var null|ChangeFrequency
     */
    private $changeFrequency;

    /**
     * @var null|float
     */
    private $priority;

    /**
     * Location constructor.
     *
     * @param string               $location
     * @param null|\DateTime       $lastModification
     * @param null|ChangeFrequency $changeFrequency
     * @param null|float           $priority
     */
    public function __construct(
        string $location,
        ?\DateTime $lastModification = null,
        ?ChangeFrequency $changeFrequency = null,
        ?float $priority = 0.5
    ) {
        if ($priority <= 0.0 || $priority > 1.0) {
            throw new \OutOfRangeException(sprintf('Priority has to be number between 0.0 and 1.0, you have provided %.2f', $priority));
        }

        $this->location = $location;
        $this->lastModification = $lastModification;
        $this->changeFrequency = $changeFrequency;
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return null|\DateTime
     */
    public function getLastModification(): ?\DateTime
    {
        return $this->lastModification;
    }

    /**
     * @return null|ChangeFrequency
     */
    public function getChangeFrequency(): ?ChangeFrequency
    {
        return $this->changeFrequency;
    }

    /**
     * @return null|float
     */
    public function getPriority(): ?float
    {
        return $this->priority;
    }
}

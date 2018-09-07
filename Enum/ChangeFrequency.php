<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Sitemap\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\Enum;

/**
 * Class ChangeFrequency.
 *
 * @method static ChangeFrequency ALWAYS()
 * @method static ChangeFrequency HOURLY()
 * @method static ChangeFrequency DAILY()
 * @method static ChangeFrequency WEEKLY()
 * @method static ChangeFrequency MONTHLY()
 * @method static ChangeFrequency YEARLY()
 * @method static ChangeFrequency NEVER()
 */
final class ChangeFrequency extends Enum
{
    use AutoDiscoveredValuesTrait;

    const ALWAYS = 'always';
    const HOURLY = 'hourly';
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';
    const NEVER = 'never';
}

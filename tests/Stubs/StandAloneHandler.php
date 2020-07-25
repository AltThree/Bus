<?php

declare(strict_types=1);

/*
 * This file is part of Alt Three Bus.
 *
 * (c) Alt Three Services Limited
 * (c) Taylor Otwell
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AltThree\Tests\Bus\Stubs;

class StandAloneHandler
{
    public function handle(StandAloneCommand $command)
    {
        return $command;
    }
}

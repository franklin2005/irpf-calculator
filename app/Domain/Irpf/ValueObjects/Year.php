<?php

namespace App\Domain\Irpf\ValueObjects;

use InvalidArgumentException;

final readonly class Year
{
    public function __construct(public int $value)
    {
        if ($this->value < 2010) {
            throw new InvalidArgumentException('Year must be 2010 or greater.');
        }
    }
}

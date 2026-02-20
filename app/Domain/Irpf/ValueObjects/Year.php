<?php

namespace App\Domain\Irpf\ValueObjects;

use InvalidArgumentException;

final readonly class Year
{
    public function __construct(public int $value)
    {
        if ($this->value < 2010) {
            throw new InvalidArgumentException('El año no puede ser menor a 2010');
        }
    }
}

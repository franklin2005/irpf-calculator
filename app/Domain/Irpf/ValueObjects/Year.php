<?php

namespace App\Domain\Irpf\ValueObjects;

use InvalidArgumentException;

final readonly class Year
{
    public const MIN_SUPPORTED_YEAR = 2010;

    public const MAX_SUPPORTED_YEAR = 2030;

    /**
     * Range currently supported by this value object: 2010-2030.
     */
    public function __construct(public int $value)
    {
        if ($this->value < self::MIN_SUPPORTED_YEAR || $this->value > self::MAX_SUPPORTED_YEAR) {
            throw new InvalidArgumentException(
                sprintf(
                    'El año debe estar entre %d y %d.',
                    self::MIN_SUPPORTED_YEAR,
                    self::MAX_SUPPORTED_YEAR,
                ),
            );
        }
    }
}

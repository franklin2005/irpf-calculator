<?php

namespace App\Domain\Irpf;

use App\Domain\Irpf\ValueObjects\Money;
use App\Domain\Irpf\ValueObjects\Region;
use App\Domain\Irpf\ValueObjects\Year;
use InvalidArgumentException;

final readonly class TaxInput
{
    public function __construct(
        public Money $grossIncome,
        public Year $year,
        public ?Region $region = null,
        public int $children = 0,
    ) {
        if ($this->children < 0) {
            throw new InvalidArgumentException('Children must be zero or greater.');
        }
    }
}

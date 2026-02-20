<?php

namespace App\Domain\Irpf;

use App\Domain\Irpf\ValueObjects\Money;
use App\Domain\Irpf\ValueObjects\Region;
use App\Domain\Irpf\ValueObjects\Year;

final readonly class TaxInput
{
    public function __construct(
        public Money $grossIncome,
        public Year $year,
        public ?Region $region = null,
    ) {}
}

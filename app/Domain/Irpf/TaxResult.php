<?php

namespace App\Domain\Irpf;

use App\Domain\Irpf\ValueObjects\Money;

final readonly class TaxResult
{
    public function __construct(
        public Money $totalTax,
        public TaxBreakdown $breakdown,
    ) {}
}

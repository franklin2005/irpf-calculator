<?php

namespace App\Domain\Irpf;

use App\Domain\Irpf\ValueObjects\Money;

final readonly class TaxResult
{
    public function __construct(
        public Money $grossIncome,
        public Money $netTaxableBase,
        public Money $totalTax,
        public float $effectiveRate,
        public TaxBreakdown $breakdown,
    ) {}
}

<?php

namespace App\Domain\Irpf;

use App\Domain\Irpf\ValueObjects\Money;

final readonly class TaxBreakdown
{
    /**
     * @param  array<string, mixed>  $items
     */
    public function __construct(
        public Money $taxableBase,
        public array $items = [],
    ) {}
}

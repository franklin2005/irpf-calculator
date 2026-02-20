<?php

namespace App\Domain\Irpf;

use App\Domain\Irpf\ValueObjects\Money;

final readonly class TaxBreakdown
{
    /**
     * @param  array<int, array{
     *     from: int,
     *     to: int|null,
     *     rate: float,
     *     taxable_base_cents: int,
     *     tax_cents: int
     * }>  $stateBracketsApplied
     * @param  array<int, array{
     *     from: int,
     *     to: int|null,
     *     rate: float,
     *     taxable_base_cents: int,
     *     tax_cents: int
     * }>  $regionalBracketsApplied
     */
    public function __construct(
        public Money $taxableBase,
        public Money $personalMinimum,
        public Money $familyMinimum,
        public Money $netTaxableBase,
        public Money $stateTax,
        public Money $regionalTax,
        public array $stateBracketsApplied = [],
        public array $regionalBracketsApplied = [],
    ) {}
}

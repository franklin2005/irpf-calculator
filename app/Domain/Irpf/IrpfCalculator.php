<?php

namespace App\Domain\Irpf;

use App\Domain\Irpf\Contracts\TaxTableRepositoryInterface;
use App\Domain\Irpf\ValueObjects\Money;

final class IrpfCalculator
{
    public function __construct(
        private TaxTableRepositoryInterface $taxTableRepository,
    ) {}

    public function calculate(TaxInput $input): TaxResult
    {
        $this->taxTableRepository->byYearAndRegion($input->year, $input->region);

        return new TaxResult(
            totalTax: Money::zero(),
            breakdown: new TaxBreakdown(
                taxableBase: $input->grossIncome,
            ),
        );
    }
}

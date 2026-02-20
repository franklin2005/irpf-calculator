<?php

namespace App\Application\Irpf;

use App\Domain\Irpf\IrpfCalculator;
use App\Domain\Irpf\TaxInput;
use App\Domain\Irpf\TaxResult;

final class CalculateIrpfUseCase
{
    public function __construct(
        private IrpfCalculator $irpfCalculator,
    ) {}

    public function execute(TaxInput $input): TaxResult
    {
        return $this->irpfCalculator->calculate($input);
    }
}

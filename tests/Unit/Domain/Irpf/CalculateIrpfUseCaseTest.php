<?php

namespace Tests\Unit\Domain\Irpf;

use App\Application\Irpf\CalculateIrpfUseCase;
use App\Domain\Irpf\Contracts\TaxTableRepositoryInterface;
use App\Domain\Irpf\IrpfCalculator;
use App\Domain\Irpf\TaxInput;
use App\Domain\Irpf\TaxResult;
use App\Domain\Irpf\ValueObjects\Money;
use App\Domain\Irpf\ValueObjects\Region;
use App\Domain\Irpf\ValueObjects\Year;
use PHPUnit\Framework\TestCase;

class CalculateIrpfUseCaseTest extends TestCase
{
    public function test_it_receives_tax_input_and_returns_tax_result(): void
    {
        $repositoryStub = new class implements TaxTableRepositoryInterface
        {
            public function byYearAndRegion(Year $year, ?Region $region = null): array
            {
                return [];
            }
        };

        $useCase = new CalculateIrpfUseCase(
            new IrpfCalculator($repositoryStub),
        );

        $input = new TaxInput(
            grossIncome: new Money(3500000),
            year: new Year(2025),
            region: null,
        );

        $result = $useCase->execute($input);

        $this->assertInstanceOf(TaxResult::class, $result);
    }
}

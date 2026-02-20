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
                return [
                    'state_brackets' => [
                        ['from' => 0, 'to' => 5000, 'rate' => 0.095],
                        ['from' => 5000, 'to' => null, 'rate' => 0.12],
                    ],
                    'regional_brackets' => [
                        ['from' => 0, 'to' => 5000, 'rate' => 0.10],
                        ['from' => 5000, 'to' => null, 'rate' => 0.125],
                    ],
                    'personal_minimums' => [
                        'base' => 5550,
                    ],
                    'family_minimums' => [
                        'per_child' => 2400,
                    ],
                    'reductions' => [],
                ];
            }
        };

        $useCase = new CalculateIrpfUseCase(
            new IrpfCalculator($repositoryStub),
        );

        $input = new TaxInput(
            grossIncome: new Money(3500000),
            year: new Year(2026),
            region: Region::Asturias,
        );

        $result = $useCase->execute($input);

        $this->assertInstanceOf(TaxResult::class, $result);
    }
}

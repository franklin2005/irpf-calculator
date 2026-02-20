<?php

namespace Tests\Unit\Domain\Irpf;

use App\Domain\Irpf\IrpfCalculator;
use App\Domain\Irpf\TaxInput;
use App\Domain\Irpf\ValueObjects\Money;
use App\Domain\Irpf\ValueObjects\Region;
use App\Domain\Irpf\ValueObjects\Year;
use App\Infrastructure\Irpf\FileTaxTableRepository;
use PHPUnit\Framework\TestCase;

class IrpfCalculatorTest extends TestCase
{
    public function test_low_income_produces_positive_tax_and_multiple_brackets(): void
    {
        $calculator = $this->makeCalculator();

        $result = $calculator->calculate($this->makeInput(15000));

        $this->assertGreaterThan(0, $result->totalTax->cents);
        $this->assertLessThan(0.305, $result->effectiveRate);
        $this->assertGreaterThanOrEqual(2, count($result->breakdown->stateBracketsApplied));
        $this->assertGreaterThanOrEqual(2, count($result->breakdown->regionalBracketsApplied));
    }

    public function test_medium_income_has_higher_total_tax_and_effective_rate_than_low_income(): void
    {
        $calculator = $this->makeCalculator();

        $lowIncomeResult = $calculator->calculate($this->makeInput(15000));
        $mediumIncomeResult = $calculator->calculate($this->makeInput(30000));

        $this->assertGreaterThan($lowIncomeResult->totalTax->cents, $mediumIncomeResult->totalTax->cents);
        $this->assertGreaterThan($lowIncomeResult->effectiveRate, $mediumIncomeResult->effectiveRate);
    }

    public function test_children_reduce_total_tax_and_effective_rate_for_same_income(): void
    {
        $calculator = $this->makeCalculator();

        $withoutChildren = $calculator->calculate($this->makeInput(25000, 0));
        $withChildren = $calculator->calculate($this->makeInput(25000, 2));

        $this->assertLessThan($withoutChildren->totalTax->cents, $withChildren->totalTax->cents);
        $this->assertLessThan($withoutChildren->effectiveRate, $withChildren->effectiveRate);
    }

    private function makeCalculator(): IrpfCalculator
    {
        return new IrpfCalculator(
            new FileTaxTableRepository($this->projectTaxTablesPath()),
        );
    }

    private function makeInput(int $grossIncomeEuros, int $children = 0): TaxInput
    {
        return new TaxInput(
            grossIncome: new Money($grossIncomeEuros * 100),
            year: new Year(2026),
            region: Region::Asturias,
            children: $children,
        );
    }

    private function projectTaxTablesPath(): string
    {
        return dirname(__DIR__, 4).DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'tax';
    }
}

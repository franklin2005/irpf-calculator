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
    public function test_2026_asturias_low_income_produces_positive_tax_and_non_empty_brackets(): void
    {
        $calculator = $this->makeCalculator();

        $result = $calculator->calculate($this->makeInput(15000));

        $this->assertGreaterThan(0, $result->totalTax->cents);
        $this->assertLessThan(0.20, $result->effectiveRate);
        $this->assertNotEmpty($result->breakdown->stateBracketsApplied);
        $this->assertNotEmpty($result->breakdown->regionalBracketsApplied);
    }

    public function test_2026_asturias_medium_income_has_higher_total_tax_and_effective_rate_than_low_income(): void
    {
        $calculator = $this->makeCalculator();

        $lowIncomeResult = $calculator->calculate($this->makeInput(15000));
        $mediumIncomeResult = $calculator->calculate($this->makeInput(30000));

        $this->assertGreaterThan($lowIncomeResult->totalTax->cents, $mediumIncomeResult->totalTax->cents);
        $this->assertGreaterThan($lowIncomeResult->effectiveRate, $mediumIncomeResult->effectiveRate);
        $this->assertGreaterThan($lowIncomeResult->breakdown->stateTax->cents, $mediumIncomeResult->breakdown->stateTax->cents);
        $this->assertGreaterThan($lowIncomeResult->breakdown->regionalTax->cents, $mediumIncomeResult->breakdown->regionalTax->cents);
    }

    public function test_2026_asturias_children_reduce_total_tax_and_effective_rate_for_same_income(): void
    {
        $calculator = $this->makeCalculator();

        $withoutChildren = $calculator->calculate($this->makeInput(30000, 0));
        $withChildren = $calculator->calculate($this->makeInput(30000, 2));

        $this->assertLessThan($withoutChildren->totalTax->cents, $withChildren->totalTax->cents);
        $this->assertLessThan($withoutChildren->effectiveRate, $withChildren->effectiveRate);
        $this->assertGreaterThan(0, $withChildren->breakdown->familyMinimum->cents);
    }

    public function test_2025_asturias_low_income_produces_positive_tax_and_non_empty_brackets(): void
    {
        $calculator = $this->makeCalculator();

        $result = $calculator->calculate($this->makeInput(15000, 0, 2025));

        $this->assertGreaterThan(0, $result->totalTax->cents);
        $this->assertLessThan(0.20, $result->effectiveRate);
        $this->assertGreaterThan(0, $result->breakdown->personalMinimum->cents);
        $this->assertNotEmpty($result->breakdown->stateBracketsApplied);
        $this->assertNotEmpty($result->breakdown->regionalBracketsApplied);
    }

    public function test_2025_asturias_medium_income_has_higher_total_tax_and_effective_rate_than_low_income(): void
    {
        $calculator = $this->makeCalculator();

        $lowIncomeResult = $calculator->calculate($this->makeInput(15000, 0, 2025));
        $mediumIncomeResult = $calculator->calculate($this->makeInput(30000, 0, 2025));

        $this->assertGreaterThan($lowIncomeResult->totalTax->cents, $mediumIncomeResult->totalTax->cents);
        $this->assertGreaterThan($lowIncomeResult->effectiveRate, $mediumIncomeResult->effectiveRate);
        $this->assertGreaterThan($lowIncomeResult->breakdown->stateTax->cents, $mediumIncomeResult->breakdown->stateTax->cents);
        $this->assertGreaterThan($lowIncomeResult->breakdown->regionalTax->cents, $mediumIncomeResult->breakdown->regionalTax->cents);
    }

    public function test_2025_asturias_children_reduce_total_tax_and_effective_rate_for_same_income(): void
    {
        $calculator = $this->makeCalculator();

        $withoutChildren = $calculator->calculate($this->makeInput(30000, 0, 2025));
        $withChildren = $calculator->calculate($this->makeInput(30000, 2, 2025));

        $this->assertLessThan($withoutChildren->totalTax->cents, $withChildren->totalTax->cents);
        $this->assertLessThan($withoutChildren->effectiveRate, $withChildren->effectiveRate);
        $this->assertGreaterThan(0, $withChildren->breakdown->familyMinimum->cents);
        $this->assertGreaterThan(0, $withChildren->breakdown->personalMinimum->cents);
    }

    public function test_2025_and_2026_asturias_can_generate_different_results_for_same_input(): void
    {
        $calculator = $this->makeCalculator();

        $result2025 = $calculator->calculate($this->makeInput(30000, 0, 2025));
        $result2026 = $calculator->calculate($this->makeInput(30000, 0, 2026));

        $this->assertGreaterThan(0, $result2025->totalTax->cents);
        $this->assertGreaterThan(0, $result2026->totalTax->cents);
        $this->assertNotSame($result2025->totalTax->cents, $result2026->totalTax->cents);
    }

    public function test_ceuta_melilla_bonus_reduces_total_tax_and_effective_rate_for_same_input(): void
    {
        $calculator = $this->makeCalculator();

        $withoutBonus = $calculator->calculate($this->makeInput(30000, 1, 2026, false));
        $withBonus = $calculator->calculate($this->makeInput(30000, 1, 2026, true));

        $this->assertLessThan($withoutBonus->totalTax->cents, $withBonus->totalTax->cents);
        $this->assertGreaterThan(0, $withBonus->breakdown->ceutaMelillaDeduction->cents);
        $this->assertLessThan($withoutBonus->effectiveRate, $withBonus->effectiveRate);
        $this->assertSame($withoutBonus->breakdown->grossTax->cents, $withBonus->breakdown->grossTax->cents);
    }

    private function makeCalculator(): IrpfCalculator
    {
        return new IrpfCalculator(
            new FileTaxTableRepository($this->projectTaxTablesPath()),
        );
    }

    private function makeInput(int $grossIncomeEuros, int $children = 0, int $year = 2026, bool $ceutaMelilla = false): TaxInput
    {
        return new TaxInput(
            grossIncome: new Money($grossIncomeEuros * 100),
            year: new Year($year),
            region: Region::Asturias,
            children: $children,
            ceutaMelilla: $ceutaMelilla,
        );
    }

    private function projectTaxTablesPath(): string
    {
        return dirname(__DIR__, 4).DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'tax';
    }
}

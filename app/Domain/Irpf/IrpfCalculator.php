<?php

namespace App\Domain\Irpf;

use App\Domain\Irpf\Contracts\TaxTableRepositoryInterface;
use App\Domain\Irpf\ValueObjects\Money;

final class IrpfCalculator
{
    public function __construct(
        private TaxTableRepositoryInterface $taxTableRepository,
    ) {}

    /**
     * MVP assumptions:
     * - Taxable base equals gross annual income.
     * - Personal minimum uses personal_minimums.base from table.
     * - Family minimum uses family_minimums.per_child multiplied by TaxInput children.
     * - Net taxable base is max(0, taxable base - personal minimum - family minimum).
     */
    public function calculate(TaxInput $input): TaxResult
    {
        $table = $this->taxTableRepository->byYearAndRegion($input->year, $input->region);

        $taxableBase = $input->grossIncome;
        $personalMinimum = new Money($this->toCents($this->extractInt($table['personal_minimums'] ?? [], 'base')));
        $familyMinimum = new Money($this->toCents($this->extractInt($table['family_minimums'] ?? [], 'per_child') * $input->children));

        $netTaxableBaseCents = max(0, $taxableBase->cents - $personalMinimum->cents - $familyMinimum->cents);
        $netTaxableBase = new Money($netTaxableBaseCents);

        $stateCalculation = $this->calculateProgressiveTax($netTaxableBaseCents, $table['state_brackets'] ?? []);
        $regionalCalculation = $this->calculateProgressiveTax($netTaxableBaseCents, $table['regional_brackets'] ?? []);

        $stateTax = new Money($stateCalculation['total_tax_cents']);
        $regionalTax = new Money($regionalCalculation['total_tax_cents']);
        $totalTax = new Money($stateTax->cents + $regionalTax->cents);
        $effectiveRate = $taxableBase->cents > 0 ? $totalTax->cents / $taxableBase->cents : 0.0;

        return new TaxResult(
            grossIncome: $taxableBase,
            netTaxableBase: $netTaxableBase,
            totalTax: $totalTax,
            effectiveRate: $effectiveRate,
            breakdown: new TaxBreakdown(
                taxableBase: $taxableBase,
                personalMinimum: $personalMinimum,
                familyMinimum: $familyMinimum,
                netTaxableBase: $netTaxableBase,
                stateTax: $stateTax,
                regionalTax: $regionalTax,
                stateBracketsApplied: $stateCalculation['applied_brackets'],
                regionalBracketsApplied: $regionalCalculation['applied_brackets'],
            ),
        );
    }

    /**
     * @param  array<string, mixed>  $values
     */
    private function extractInt(array $values, string $key): int
    {
        $value = $values[$key] ?? 0;

        if (! is_int($value) && ! is_float($value)) {
            return 0;
        }

        return (int) $value;
    }

    /**
     * @param  array<int, array{from: int, to: int|null, rate: float|int}>  $brackets
     * @return array{
     *     total_tax_cents: int,
     *     applied_brackets: array<int, array{
     *         from: int,
     *         to: int|null,
     *         rate: float,
     *         taxable_base_cents: int,
     *         tax_cents: int
     *     }>
     * }
     */
    private function calculateProgressiveTax(int $netTaxableBaseCents, array $brackets): array
    {
        $totalTaxCents = 0;
        $appliedBrackets = [];

        foreach ($brackets as $bracket) {
            $fromCents = $this->toCents($bracket['from']);
            $toCents = $bracket['to'] !== null ? $this->toCents($bracket['to']) : null;
            $rate = (float) $bracket['rate'];
            $upperBound = $toCents ?? $netTaxableBaseCents;
            $taxableBaseInBracket = min($netTaxableBaseCents, $upperBound) - $fromCents;

            if ($taxableBaseInBracket <= 0) {
                continue;
            }

            $taxInBracketCents = (int) round($taxableBaseInBracket * $rate, 0, PHP_ROUND_HALF_UP);
            $totalTaxCents += $taxInBracketCents;

            $appliedBrackets[] = [
                'from' => $bracket['from'],
                'to' => $bracket['to'],
                'rate' => $rate,
                'taxable_base_cents' => $taxableBaseInBracket,
                'tax_cents' => $taxInBracketCents,
            ];
        }

        return [
            'total_tax_cents' => $totalTaxCents,
            'applied_brackets' => $appliedBrackets,
        ];
    }

    private function toCents(int|float $amount): int
    {
        return (int) round($amount * 100, 0, PHP_ROUND_HALF_UP);
    }
}

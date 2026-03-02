<?php

namespace App\Livewire\Irpf;

use App\Application\Irpf\CalculateIrpfUseCase;
use App\Domain\Irpf\Contracts\TaxTableRepositoryInterface;
use App\Domain\Irpf\Exceptions\InvalidTaxTableSchemaException;
use App\Domain\Irpf\Exceptions\MissingTaxTableException;
use App\Domain\Irpf\TaxInput;
use App\Domain\Irpf\ValueObjects\Money;
use App\Domain\Irpf\ValueObjects\Region;
use App\Domain\Irpf\ValueObjects\Year;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RegionInfoPage extends Component
{
    /**
     * @var array<int, int>
     */
    private const SUPPORTED_YEARS = [2025, 2026];

    public int $year;

    public string $regionSlug;

    public string $regionName;

    public string $seoTitle;

    public string $seoDescription;

    /**
     * @var array<string, string>
     */
    public array $regionOptions = [];

    /**
     * @var array<int, array<string, mixed>>
     */
    public array $exampleResults = [];

    /**
     * @var array<int, array{from: int, to: int|null, rate: float}>
     */
    public array $stateBrackets = [];

    /**
     * @var array<int, array{from: int, to: int|null, rate: float}>
     */
    public array $regionalBrackets = [];

    public function mount(int $year, string $regionSlug): void
    {
        if (! $this->isValidYear($year)) {
            abort(404);
        }

        $region = Region::tryFrom($regionSlug);

        if ($region === null) {
            abort(404);
        }

        $this->year = $year;
        $this->regionSlug = $regionSlug;
        $this->regionOptions = $this->buildRegionOptions();
        $this->regionName = $this->labelForRegion($region);
        $this->seoTitle = "IRPF {$this->year} en {$this->regionName}: tramos y ejemplo orientativo";
        $this->seoDescription = "Consulta los tramos de IRPF {$this->year} en {$this->regionName}, junto con ejemplos orientativos de cálculo y acceso directo a la calculadora.";
        $this->exampleResults = [];

        $this->loadBrackets($year, $region);
        $this->exampleResults = $this->buildExampleResults($year, $region);
        $this->dispatch('region-page-viewed',
            year: $this->year,
            regionSlug: $this->regionSlug,
            regionName: $this->regionName,
        );
    }

    public function render(): View
    {
        return view('livewire.irpf.region-info-page')
            ->layout('components.layouts.app', [
                'title' => $this->seoTitle,
                'metaDescription' => $this->seoDescription,
                'canonical' => route('irpf.region.show', [
                    'year' => $this->year,
                    'regionSlug' => $this->regionSlug,
                ]),
            ]);
    }

    private function isValidYear(int $year): bool
    {
        return in_array($year, self::SUPPORTED_YEARS, true);
    }

    private function loadBrackets(int $year, Region $region): void
    {
        try {
            $repository = app(TaxTableRepositoryInterface::class);
            $tables = $repository->byYearAndRegion(new Year($year), $region);

            $this->stateBrackets = $this->normalizeBrackets($tables['state_brackets'] ?? []);
            $this->regionalBrackets = $this->normalizeBrackets($tables['regional_brackets'] ?? []);
        } catch (MissingTaxTableException|InvalidTaxTableSchemaException $exception) {
            $this->stateBrackets = [];
            $this->regionalBrackets = [];

            report($exception);
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $brackets
     * @return array<int, array{from: int, to: int|null, rate: float}>
     */
    private function normalizeBrackets(array $brackets): array
    {
        $normalized = [];

        foreach ($brackets as $bracket) {
            if (! isset($bracket['from'], $bracket['rate'])) {
                continue;
            }

            $normalized[] = [
                'from' => (int) $bracket['from'],
                'to' => array_key_exists('to', $bracket) && $bracket['to'] !== null ? (int) $bracket['to'] : null,
                'rate' => round((float) $bracket['rate'] * 100, 2),
            ];
        }

        return $normalized;
    }

    /**
     * @return array<int, array{label: string, gross_income: string, total_tax: string, effective_rate: string}>
     */
    private function buildExampleResults(int $year, Region $region): array
    {
        $useCase = app(CalculateIrpfUseCase::class);
        $profiles = [
            ['gross_income_eur' => 15000, 'children' => 0],
            ['gross_income_eur' => 30000, 'children' => 1],
            ['gross_income_eur' => 45000, 'children' => 2],
        ];
        $results = [];

        foreach ($profiles as $profile) {
            try {
                $taxResult = $useCase->execute(new TaxInput(
                    grossIncome: new Money($profile['gross_income_eur'] * 100),
                    year: new Year($year),
                    region: $region,
                    children: $profile['children'],
                ));
            } catch (\Throwable $exception) {
                report($exception);

                continue;
            }

            $results[] = [
                'label' => $this->buildExampleLabel($profile['gross_income_eur'], $profile['children']),
                'gross_income' => $this->formatEuro($profile['gross_income_eur'] * 100),
                'total_tax' => $this->formatEuro($taxResult->totalTax->cents),
                'effective_rate' => number_format($taxResult->effectiveRate * 100, 2, ',', '.').' %',
            ];
        }

        return $results;
    }

    private function buildExampleLabel(int $grossIncomeEur, int $children): string
    {
        if ($children === 0) {
            return number_format($grossIncomeEur, 0, ',', '.').' € brutos, sin hijos';
        }

        $childrenLabel = $children === 1 ? '1 hijo' : "{$children} hijos";

        return number_format($grossIncomeEur, 0, ',', '.')." € brutos, {$childrenLabel}";
    }

    private function formatEuro(int $amountInCents): string
    {
        return number_format($amountInCents / 100, 2, ',', '.').' €';
    }

    /**
     * @return array<string, string>
     */
    private function buildRegionOptions(): array
    {
        $options = [];

        foreach (Region::cases() as $region) {
            $options[$region->value] = $this->labelForRegion($region);
        }

        return $options;
    }

    private function labelForRegion(Region $region): string
    {
        return match ($region) {
            Region::Andalucia => 'Andalucía',
            Region::Aragon => 'Aragón',
            Region::Asturias => 'Asturias',
            Region::Baleares => 'Baleares',
            Region::Canarias => 'Canarias',
            Region::Cantabria => 'Cantabria',
            Region::CastillaLaMancha => 'Castilla-La Mancha',
            Region::CastillaYLeon => 'Castilla y León',
            Region::Cataluna => 'Cataluña',
            Region::ComunidadValenciana => 'Comunidad Valenciana',
            Region::Extremadura => 'Extremadura',
            Region::Galicia => 'Galicia',
            Region::LaRioja => 'La Rioja',
            Region::Madrid => 'Madrid',
            Region::Murcia => 'Murcia',
            Region::Navarra => 'Navarra',
            Region::PaisVasco => 'País Vasco',
        };
    }
}

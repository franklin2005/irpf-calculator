<?php

namespace App\Livewire\Irpf;

use App\Application\Irpf\CalculateIrpfUseCase;
use App\Domain\Irpf\Exceptions\InvalidTaxTableSchemaException;
use App\Domain\Irpf\Exceptions\MissingTaxTableException;
use App\Domain\Irpf\TaxInput;
use App\Domain\Irpf\TaxResult;
use App\Domain\Irpf\ValueObjects\Money;
use App\Domain\Irpf\ValueObjects\Region;
use App\Domain\Irpf\ValueObjects\Year;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Url;
use Livewire\Component;

class IrpfCalculatorPage extends Component
{
    /**
     * @var array<int, int>
     */
    public const SUPPORTED_YEARS = [2025, 2026];

    public const CEUTA_MELILLA_SLUG = 'ceuta_melilla';

    public int $year = 2026;

    #[Url(except: 'asturias')]
    public string $regionSlug = 'asturias';

    /**
     * @var array<string, string>
     */
    public array $regionOptions = [];

    #[Url(except: null)]
    public ?int $grossIncome = null;

    #[Url(except: 0)]
    public int $children = 0;

    public bool $ceutaMelilla = false;

    public ?TaxResult $result = null;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $resultData = null;

    public ?string $domainError = null;

    private CalculateIrpfUseCase $calculateIrpfUseCase;

    public function boot(CalculateIrpfUseCase $calculateIrpfUseCase): void
    {
        $this->calculateIrpfUseCase = $calculateIrpfUseCase;
    }

    public function mount(int $year): void
    {
        if (! in_array($year, self::SUPPORTED_YEARS, true)) {
            abort(404);
        }

        $this->year = $year;
        $this->regionOptions = $this->buildRegionOptions();
        $this->ceutaMelilla = $this->shouldApplyCeutaMelillaBonus($this->regionSlug);

        if (
            $this->grossIncome !== null
            && $this->grossIncome > 0
            && $this->children >= 0
            && $this->isValidRegionSlug($this->regionSlug)
        ) {
            $this->calculate();
        }
    }

    public function calculate(): void
    {
        $this->domainError = null;

        $validated = $this->validate($this->validationRules(), [
            'grossIncome.required' => 'Debes indicar los ingresos brutos anuales.',
            'grossIncome.integer' => 'Los ingresos deben ser un numero entero en euros.',
            'grossIncome.min' => 'Los ingresos deben ser mayores que cero.',
            'children.required' => 'Debes indicar el numero de hijos.',
            'children.integer' => 'El numero de hijos debe ser un entero.',
            'children.min' => 'El numero de hijos no puede ser negativo.',
            'year.required' => 'Debes seleccionar un ano fiscal.',
            'year.in' => 'El ano fiscal seleccionado no es valido.',
            'regionSlug.required' => 'Debes seleccionar una comunidad autonoma.',
            'regionSlug.in' => 'La comunidad autonoma seleccionada no es valida.',
        ]);

        try {
            $region = $this->regionFromSlug($validated['regionSlug']);
            $applyCeutaMelillaBonus = $this->shouldApplyCeutaMelillaBonus($validated['regionSlug']);
            $this->ceutaMelilla = $applyCeutaMelillaBonus;

            if ($this->isUnsupportedForalRegion($region)) {
                $this->result = null;
                $this->resultData = null;
                $this->domainError = $this->unsupportedForalRegionMessage();

                return;
            }

            $input = new TaxInput(
                grossIncome: new Money($validated['grossIncome'] * 100),
                year: new Year($this->year),
                region: $region,
                children: $validated['children'],
                ceutaMelilla: $applyCeutaMelillaBonus,
            );

            $this->result = $this->calculateIrpfUseCase->execute($input);
            $this->resultData = $this->mapResultForView($this->result);
            $this->dispatch('irpf-calculated',
                year: $this->year,
                regionSlug: $validated['regionSlug'],
                grossIncome: $validated['grossIncome'],
                children: $validated['children'],
                ceutaMelilla: $applyCeutaMelillaBonus,
                totalTax: round($this->result->totalTax->cents / 100, 2),
                effectiveRate: round($this->result->effectiveRate * 100, 2),
            );
        } catch (MissingTaxTableException|InvalidTaxTableSchemaException $exception) {
            $this->result = null;
            $this->resultData = null;
            $this->domainError = 'No se han podido cargar las tablas IRPF para el calculo solicitado.';
            report($exception);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            $this->result = null;
            $this->resultData = null;
            $this->domainError = 'Se produjo un error inesperado al calcular el IRPF.';
            report($exception);
        }
    }

    public function selectRegion(string $slug): void
    {
        if (! $this->isValidRegionSlug($slug)) {
            throw ValidationException::withMessages([
                'regionSlug' => 'La comunidad autonoma seleccionada no es valida.',
            ]);
        }

        $this->regionSlug = $slug;
        $this->ceutaMelilla = $this->shouldApplyCeutaMelillaBonus($slug);
        $this->result = null;
        $this->resultData = null;
    }

    public function selectYear(int $year): void
    {
        if (! $this->isValidYear($year)) {
            throw ValidationException::withMessages([
                'year' => 'El ano fiscal seleccionado no es valido.',
            ]);
        }

        $this->year = $year;
        $this->result = null;
        $this->resultData = null;
    }

    public function dehydrate(): void
    {
        $this->result = null;
    }

    public function render(): View
    {
        return view('livewire.irpf.irpf-calculator-page')
            ->layout('components.layouts.app', [
                'title' => "Calculadora IRPF {$this->year}",
            ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function mapResultForView(TaxResult $result): array
    {
        return [
            'gross_income_eur' => $result->grossIncome->cents / 100,
            'net_taxable_base_eur' => $result->netTaxableBase->cents / 100,
            'total_tax_eur' => $result->totalTax->cents / 100,
            'effective_rate_percent' => $result->effectiveRate * 100,
            'personal_minimum_eur' => $result->breakdown->personalMinimum->cents / 100,
            'family_minimum_eur' => $result->breakdown->familyMinimum->cents / 100,
            'state_tax_eur' => $result->breakdown->stateTax->cents / 100,
            'regional_tax_eur' => $result->breakdown->regionalTax->cents / 100,
            'gross_tax_eur' => $result->breakdown->grossTax->cents / 100,
            'ceuta_melilla_deduction_eur' => $result->breakdown->ceutaMelillaDeduction->cents / 100,
            'state_brackets_applied_count' => count($result->breakdown->stateBracketsApplied),
            'regional_brackets_applied_count' => count($result->breakdown->regionalBracketsApplied),
        ];
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function validationRules(): array
    {
        return [
            'grossIncome' => ['required', 'integer', 'min:1'],
            'children' => ['required', 'integer', 'min:0'],
            'year' => ['required', Rule::in(self::SUPPORTED_YEARS)],
            'regionSlug' => ['required', Rule::in(array_keys($this->regionOptions))],
        ];
    }

    private function regionFromSlug(string $slug): Region
    {
        if ($slug === self::CEUTA_MELILLA_SLUG) {
            return Region::Andalucia;
        }

        $region = Region::tryFrom($slug);

        if ($region === null) {
            throw ValidationException::withMessages([
                'regionSlug' => 'La comunidad autonoma seleccionada no es valida.',
            ]);
        }

        return $region;
    }

    private function isValidRegionSlug(string $slug): bool
    {
        return array_key_exists($slug, $this->regionOptions);
    }

    private function isValidYear(int $year): bool
    {
        return in_array($year, self::SUPPORTED_YEARS, true);
    }

    private function isUnsupportedForalRegion(Region $region): bool
    {
        return $region === Region::Navarra || $region === Region::PaisVasco;
    }

    private function unsupportedForalRegionMessage(): string
    {
        return "Navarra y País Vasco aplican un sistema fiscal propio (régimen foral), con reglas distintas a las del IRPF estatal + autonómico.\n\nPor eso, esta calculadora —basada en el régimen común— no puede generar un resultado válido para estas comunidades.\n\nEstamos desarrollando una versión compatible con el régimen foral.";
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

        $options[self::CEUTA_MELILLA_SLUG] = 'Ceuta y Melilla (bonificacion 60%)';

        return $options;
    }

    private function shouldApplyCeutaMelillaBonus(string $regionSlug): bool
    {
        return $regionSlug === self::CEUTA_MELILLA_SLUG;
    }

    private function labelForRegion(Region $region): string
    {
        return match ($region) {
            Region::Andalucia => "Andaluc\u{00ED}a",
            Region::Aragon => "Arag\u{00F3}n",
            Region::Asturias => 'Asturias',
            Region::Baleares => 'Baleares',
            Region::Canarias => 'Canarias',
            Region::Cantabria => 'Cantabria',
            Region::CastillaLaMancha => 'Castilla-La Mancha',
            Region::CastillaYLeon => "Castilla y Le\u{00F3}n",
            Region::Cataluna => "Catalu\u{00F1}a",
            Region::ComunidadValenciana => 'Comunidad Valenciana',
            Region::Extremadura => 'Extremadura',
            Region::Galicia => 'Galicia',
            Region::LaRioja => 'La Rioja',
            Region::Madrid => 'Madrid',
            Region::Murcia => 'Murcia',
            Region::Navarra => 'Navarra',
            Region::PaisVasco => "Pa\u{00ED}s Vasco",
        };
    }
}

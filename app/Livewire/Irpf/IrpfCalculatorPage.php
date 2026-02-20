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
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class IrpfCalculatorPage extends Component
{
    public int $year = 2026;

    public string $region = 'Asturias';

    public ?int $grossIncome = null;

    public int $children = 0;

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
        $this->year = $year;
    }

    public function calculate(): void
    {
        $this->domainError = null;

        $validated = $this->validate([
            'grossIncome' => ['required', 'integer', 'min:1'],
            'children' => ['required', 'integer', 'min:0'],
        ], [
            'grossIncome.required' => 'Debes indicar los ingresos brutos anuales.',
            'grossIncome.integer' => 'Los ingresos deben ser un numero entero en euros.',
            'grossIncome.min' => 'Los ingresos deben ser mayores que cero.',
            'children.required' => 'Debes indicar el numero de hijos.',
            'children.integer' => 'El numero de hijos debe ser un entero.',
            'children.min' => 'El numero de hijos no puede ser negativo.',
        ]);

        try {
            $input = new TaxInput(
                grossIncome: new Money($validated['grossIncome'] * 100),
                year: new Year($this->year),
                region: Region::Asturias,
                children: $validated['children'],
            );

            $this->result = $this->calculateIrpfUseCase->execute($input);
            $this->resultData = $this->mapResultForView($this->result);
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
            'state_brackets_applied_count' => count($result->breakdown->stateBracketsApplied),
            'regional_brackets_applied_count' => count($result->breakdown->regionalBracketsApplied),
        ];
    }
}

<?php

namespace Tests\Feature;

use App\Livewire\Irpf\IrpfCalculatorPage;
use Livewire\Livewire;
use Tests\TestCase;

class IrpfCalculatorPageTest extends TestCase
{
    public function test_irpf_calculator_page_is_accessible_for_2026(): void
    {
        $response = $this->get('/calculadora-irpf/2026');

        $response
            ->assertOk()
            ->assertSee('Datos principales')
            ->assertSee('Familia')
            ->assertSee('Deducciones (MVP)')
            ->assertSee('Resultado orientativo');
    }

    public function test_irpf_calculator_page_returns_404_for_unsupported_year(): void
    {
        $response = $this->get('/calculadora-irpf/2025');

        $response->assertNotFound();
    }

    public function test_irpf_calculator_page_accepts_query_string_state(): void
    {
        $response = $this->get('/calculadora-irpf/2026?grossIncome=30000&children=2');

        $response
            ->assertOk()
            ->assertSee('grossIncome&quot;:30000', false)
            ->assertSee('children&quot;:2', false);
    }

    public function test_livewire_component_calculates_irpf_result(): void
    {
        Livewire::test(IrpfCalculatorPage::class, ['year' => 2026])
            ->set('grossIncome', 30000)
            ->set('children', 1)
            ->call('calculate')
            ->assertHasNoErrors()
            ->assertSet('resultData', function ($value): bool {
                return is_array($value) && array_key_exists('total_tax_eur', $value);
            });
    }

    public function test_livewire_component_reads_query_string_properties(): void
    {
        Livewire::withQueryParams([
            'grossIncome' => 30000,
            'children' => 2,
        ])->test(IrpfCalculatorPage::class, ['year' => 2026])
            ->assertSet('grossIncome', 30000)
            ->assertSet('children', 2);
    }

    public function test_livewire_component_auto_calculates_when_query_string_is_valid(): void
    {
        Livewire::withQueryParams([
            'grossIncome' => 30000,
            'children' => 2,
        ])->test(IrpfCalculatorPage::class, ['year' => 2026])
            ->assertSet('resultData', function ($value): bool {
                return is_array($value)
                    && array_key_exists('total_tax_eur', $value)
                    && is_numeric($value['total_tax_eur'])
                    && $value['total_tax_eur'] > 0;
            });
    }
}

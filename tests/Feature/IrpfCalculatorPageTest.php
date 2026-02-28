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

    public function test_irpf_calculator_page_is_accessible_for_2025(): void
    {
        $response = $this->get('/calculadora-irpf/2025');

        $response
            ->assertOk()
            ->assertSee('Datos principales')
            ->assertSee('2025');
    }

    public function test_irpf_calculator_page_returns_404_for_unsupported_year(): void
    {
        $response = $this->get('/calculadora-irpf/2024');

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
            'regionSlug' => 'madrid',
        ])->test(IrpfCalculatorPage::class, ['year' => 2026])
            ->assertSet('grossIncome', 30000)
            ->assertSet('children', 2)
            ->assertSet('regionSlug', 'madrid');
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

    public function test_livewire_component_calculates_irpf_result_for_selected_region(): void
    {
        Livewire::test(IrpfCalculatorPage::class, ['year' => 2026])
            ->set('regionSlug', 'madrid')
            ->set('grossIncome', 30000)
            ->set('children', 1)
            ->call('calculate')
            ->assertHasNoErrors()
            ->assertSet('resultData', function ($value): bool {
                return is_array($value) && array_key_exists('total_tax_eur', $value);
            });
    }

    public function test_livewire_component_can_return_different_results_for_asturias_and_madrid(): void
    {
        $baseInput = [
            'grossIncome' => 42000,
            'children' => 1,
        ];

        $asturiasComponent = Livewire::test(IrpfCalculatorPage::class, ['year' => 2026])
            ->set('regionSlug', 'asturias')
            ->set('grossIncome', $baseInput['grossIncome'])
            ->set('children', $baseInput['children'])
            ->call('calculate')
            ->assertHasNoErrors();

        $madridComponent = Livewire::test(IrpfCalculatorPage::class, ['year' => 2026])
            ->set('regionSlug', 'madrid')
            ->set('grossIncome', $baseInput['grossIncome'])
            ->set('children', $baseInput['children'])
            ->call('calculate')
            ->assertHasNoErrors();

        $asturiasResult = $asturiasComponent->get('resultData');
        $madridResult = $madridComponent->get('resultData');

        $this->assertIsArray($asturiasResult);
        $this->assertIsArray($madridResult);
        $this->assertArrayHasKey('total_tax_eur', $asturiasResult);
        $this->assertArrayHasKey('total_tax_eur', $madridResult);
        $this->assertNotSame($asturiasResult['total_tax_eur'], $madridResult['total_tax_eur']);
    }

    public function test_livewire_component_uses_selected_year_for_calculation(): void
    {
        $input = [
            'grossIncome' => 32000,
            'children' => 1,
            'regionSlug' => 'asturias',
        ];

        $result2025 = Livewire::test(IrpfCalculatorPage::class, ['year' => 2026])
            ->call('selectYear', 2025)
            ->set('regionSlug', $input['regionSlug'])
            ->set('grossIncome', $input['grossIncome'])
            ->set('children', $input['children'])
            ->call('calculate')
            ->assertHasNoErrors()
            ->get('resultData');

        $result2026 = Livewire::test(IrpfCalculatorPage::class, ['year' => 2026])
            ->call('selectYear', 2026)
            ->set('regionSlug', $input['regionSlug'])
            ->set('grossIncome', $input['grossIncome'])
            ->set('children', $input['children'])
            ->call('calculate')
            ->assertHasNoErrors()
            ->get('resultData');

        $this->assertIsArray($result2025);
        $this->assertIsArray($result2026);
        $this->assertArrayHasKey('total_tax_eur', $result2025);
        $this->assertArrayHasKey('total_tax_eur', $result2026);
        $this->assertNotSame($result2025['total_tax_eur'], $result2026['total_tax_eur']);
    }

    public function test_irpf_calculator_page_shows_not_supported_message_for_navarra(): void
    {
        $response = $this->get('/calculadora-irpf/2026?regionSlug=navarra&grossIncome=30000&children=1');

        $response
            ->assertOk()
            ->assertSee('Régimen foral no incluido por ahora')
            ->assertSee('Navarra y País Vasco aplican un sistema fiscal propio (régimen foral)')
            ->assertSee('resultData&quot;:null', false);
    }

    public function test_irpf_calculator_page_shows_not_supported_message_for_pais_vasco(): void
    {
        $response = $this->get('/calculadora-irpf/2026?regionSlug=pais_vasco&grossIncome=30000&children=1');

        $response
            ->assertOk()
            ->assertSee('Régimen foral no incluido por ahora')
            ->assertSee('esta calculadora —basada en el régimen común— no puede generar un resultado válido para estas comunidades')
            ->assertSee('resultData&quot;:null', false);
    }
}

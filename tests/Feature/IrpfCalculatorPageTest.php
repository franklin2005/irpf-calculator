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

        $response->assertOk();
    }

    public function test_irpf_calculator_page_returns_404_for_unsupported_year(): void
    {
        $response = $this->get('/calculadora-irpf/2025');

        $response->assertNotFound();
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
}

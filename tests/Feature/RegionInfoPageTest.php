<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegionInfoPageTest extends TestCase
{
    public function test_region_info_route_returns_200_for_valid_year_and_region(): void
    {
        $response = $this->get(route('irpf.region.show', [
            'year' => 2026,
            'regionSlug' => 'asturias',
        ]));

        $response
            ->assertOk()
            ->assertSee('IRPF 2026 en Asturias')
            ->assertSee('Inicio');
    }

    public function test_region_info_route_returns_404_for_invalid_region(): void
    {
        $response = $this->get('/irpf/2026/region-invalida');

        $response->assertNotFound();
    }

    public function test_region_info_page_renders_seo_template_sections_for_asturias_2026(): void
    {
        $url = route('irpf.region.show', [
            'year' => 2026,
            'regionSlug' => 'asturias',
        ]);

        $response = $this->get($url);

        $response
            ->assertOk()
            ->assertSee('<title>IRPF 2026 en Asturias: tramos y ejemplo orientativo</title>', false)
            ->assertSee('<meta name="description" content="Consulta los tramos de IRPF 2026 en Asturias, junto con ejemplos orientativos de cálculo y acceso directo a la calculadora.">', false)
            ->assertSee('<link rel="canonical" href="'.$url.'">', false)
            ->assertSee('IRPF 2026 en Asturias')
            ->assertSee('Tramos estatales')
            ->assertSee('12.450 €')
            ->assertSee('Ejemplos orientativos de cálculo');
    }

    public function test_region_info_page_renders_sections_for_2025_madrid(): void
    {
        $response = $this->get(route('irpf.region.show', [
            'year' => 2025,
            'regionSlug' => 'madrid',
        ]));

        $response
            ->assertOk()
            ->assertSee('IRPF 2025 en Madrid')
            ->assertSee('Tramos estatales')
            ->assertSee('€')
            ->assertSee('Ejemplos orientativos de cálculo')
            ->assertSee('15.000 € brutos');
    }
}

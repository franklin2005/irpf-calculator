<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoTechnicalTest extends TestCase
{
    public function test_layout_does_not_render_ga4_snippet_when_id_is_missing(): void
    {
        config(['services.analytics.ga4_id' => null]);

        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertDontSee('googletagmanager.com/gtag/js?id=', false);
    }

    public function test_layout_renders_ga4_snippet_when_id_is_configured(): void
    {
        config(['services.analytics.ga4_id' => 'G-TEST1234']);

        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('https://www.googletagmanager.com/gtag/js?id=G-TEST1234', false)
            ->assertSee("gtag('config', 'G-TEST1234');", false);
    }

    public function test_home_page_responds_ok_and_shows_hero_title(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Calculadora IRPF 2026 para Espana');
    }

    public function test_calculator_page_renders_expected_title_and_canonical_without_query(): void
    {
        $response = $this->get('/calculadora-irpf/2026?grossIncome=30000&children=2');

        $response
            ->assertOk()
            ->assertSee('<title>Calculadora IRPF 2026 Asturias - Simulador de IRPF estimado</title>', false)
            ->assertSee('<link rel="canonical" href="'.url('/calculadora-irpf/2026').'">', false);
    }

    public function test_robots_txt_is_accessible_and_contains_user_agent_rule(): void
    {
        $response = $this->get('/robots.txt');

        $response
            ->assertOk()
            ->assertSee('User-agent: *');
    }

    public function test_sitemap_xml_is_accessible_and_contains_minimum_urls(): void
    {
        $response = $this->get('/sitemap.xml');
        $content = $response->getContent() ?: '';

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<urlset', false)
            ->assertSee(url('/'), false)
            ->assertSee(url('/calculadora-irpf/2025'), false)
            ->assertSee(url('/calculadora-irpf/2026'), false)
            ->assertSee(url('/irpf/2026/asturias'), false)
            ->assertSee(url('/irpf/2025/madrid'), false)
            ->assertSee('<lastmod>', false);

        $this->assertGreaterThan(10, substr_count($content, '<url>'));
    }

    public function test_not_found_route_uses_custom_404_page(): void
    {
        $response = $this->get('/ruta-que-no-existe');

        $response
            ->assertNotFound()
            ->assertSee('Pagina no encontrada');
    }
}

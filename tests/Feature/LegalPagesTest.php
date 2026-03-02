<?php

namespace Tests\Feature;

use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    public function test_aviso_legal_page_is_accessible(): void
    {
        $response = $this->get('/aviso-legal');

        $response
            ->assertOk()
            ->assertSee('Aviso legal');
    }

    public function test_politica_privacidad_page_is_accessible(): void
    {
        $response = $this->get('/politica-privacidad');

        $response
            ->assertOk()
            ->assertSee('Política de privacidad');
    }

    public function test_politica_cookies_page_is_accessible(): void
    {
        $response = $this->get('/politica-cookies');

        $response
            ->assertOk()
            ->assertSee('Política de cookies');
    }

    public function test_home_contains_ad_slot_placeholder(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('ad-slot', false);
    }

    public function test_calculator_contains_disclaimer_and_ad_slot(): void
    {
        $response = $this->get('/calculadora-irpf/2026');

        $response
            ->assertOk()
            ->assertSee('Esta calculadora ofrece una estimación del IRPF', false)
            ->assertSee('ad-slot', false);
    }
}

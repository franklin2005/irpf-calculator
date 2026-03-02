<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_home_page_shows_hero_and_cta(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Calculadora de IRPF 2025 y 2026 por comunidad autónoma')
            ->assertSee('Calcular IRPF');
    }
}

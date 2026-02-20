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
            ->assertSee('Calculadora IRPF 2026 para Espana')
            ->assertSee('Ir a la calculadora');
    }
}

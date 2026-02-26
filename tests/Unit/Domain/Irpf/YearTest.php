<?php

namespace Tests\Unit\Domain\Irpf;

use App\Domain\Irpf\ValueObjects\Year;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class YearTest extends TestCase
{
    public function test_it_allows_2025(): void
    {
        $year = new Year(2025);

        $this->assertSame(2025, $year->value);
    }

    public function test_it_allows_2026(): void
    {
        $year = new Year(2026);

        $this->assertSame(2026, $year->value);
    }

    public function test_it_rejects_year_below_supported_range(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Year(2009);
    }
}

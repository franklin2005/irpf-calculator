<?php

namespace App\Domain\Irpf\Contracts;

use App\Domain\Irpf\ValueObjects\Region;
use App\Domain\Irpf\ValueObjects\Year;

interface TaxTableRepositoryInterface
{
    /**
     * @return array<string, mixed>
     */
    public function byYearAndRegion(Year $year, ?Region $region = null): array;
}

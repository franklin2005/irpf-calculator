<?php

namespace Tests\Unit\Irpf;

use App\Domain\Irpf\Exceptions\InvalidTaxTableSchemaException;
use App\Domain\Irpf\Exceptions\MissingTaxTableException;
use App\Domain\Irpf\ValueObjects\Region;
use App\Domain\Irpf\ValueObjects\Year;
use App\Infrastructure\Irpf\FileTaxTableRepository;
use PHPUnit\Framework\TestCase;

class FileTaxTableRepositoryTest extends TestCase
{
    /**
     * @var array<int, int>
     */
    private const SUPPORTED_YEARS = [2025, 2026];

    /**
     * @var array<int, string>
     */
    private array $temporaryDirectories = [];

    public function test_it_loads_tax_table_for_every_supported_region_and_year_without_exceptions(): void
    {
        $repository = new FileTaxTableRepository($this->projectTaxTablesPath());

        foreach ($this->supportedRegionYearPairs() as $pair) {
            $table = $repository->byYearAndRegion(
                new Year($pair['year']),
                $pair['region'],
            );

            $this->assertIsArray(
                $table,
                sprintf(
                    'Expected table array for region %s and year %d.',
                    $pair['region']->value,
                    $pair['year'],
                ),
            );
        }
    }

    public function test_each_supported_region_and_year_table_matches_expected_schema(): void
    {
        $repository = new FileTaxTableRepository($this->projectTaxTablesPath());

        foreach ($this->supportedRegionYearPairs() as $pair) {
            $table = $repository->byYearAndRegion(
                new Year($pair['year']),
                $pair['region'],
            );

            $this->assertArrayHasKey('state_brackets', $table);
            $this->assertArrayHasKey('regional_brackets', $table);
            $this->assertArrayHasKey('personal_minimums', $table);
            $this->assertArrayHasKey('family_minimums', $table);
            $this->assertArrayHasKey('reductions', $table);

            $this->assertBracketsSchema($table['state_brackets']);
            $this->assertBracketsSchema($table['regional_brackets']);
            $this->assertBracketsAreProgressiveAndContiguous($table['state_brackets']);
            $this->assertBracketsAreProgressiveAndContiguous($table['regional_brackets']);

            $this->assertIsArray($table['personal_minimums']);
            $this->assertIsArray($table['family_minimums']);
            $this->assertIsArray($table['reductions']);
        }
    }

    public function test_it_throws_when_tax_table_file_is_missing(): void
    {
        $repository = new FileTaxTableRepository($this->projectTaxTablesPath());

        $this->expectException(MissingTaxTableException::class);

        $repository->byYearAndRegion(new Year(2030), Region::Asturias);
    }

    public function test_it_throws_when_tax_table_schema_is_invalid(): void
    {
        $basePath = $this->createTemporaryTablePath(
            2026,
            Region::Asturias->value,
            [
                'state_brackets' => [],
                'regional_brackets' => [],
                'personal_minimums' => [],
                'family_minimums' => [],
            ],
        );

        $repository = new FileTaxTableRepository($basePath);

        $this->expectException(InvalidTaxTableSchemaException::class);

        $repository->byYearAndRegion(new Year(2026), Region::Asturias);
    }

    protected function tearDown(): void
    {
        foreach ($this->temporaryDirectories as $temporaryDirectory) {
            $this->deleteDirectory($temporaryDirectory);
        }

        parent::tearDown();
    }

    private function projectTaxTablesPath(): string
    {
        return dirname(__DIR__, 3).DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'tax';
    }

    /**
     * @param  array<string, mixed>  $table
     */
    private function createTemporaryTablePath(int $year, string $region, array $table): string
    {
        $basePath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'irpf-tax-table-'.uniqid('', true);
        $yearDirectory = $basePath.DIRECTORY_SEPARATOR.$year;

        mkdir($yearDirectory, 0777, true);
        file_put_contents(
            $yearDirectory.DIRECTORY_SEPARATOR.$region.'.php',
            "<?php\n\nreturn ".var_export($table, true).";\n",
        );

        $this->temporaryDirectories[] = $basePath;

        return $basePath;
    }

    private function assertBracketsSchema(mixed $brackets): void
    {
        $this->assertIsArray($brackets);

        foreach ($brackets as $bracket) {
            $this->assertIsArray($bracket);
            $this->assertArrayHasKey('from', $bracket);
            $this->assertArrayHasKey('to', $bracket);
            $this->assertArrayHasKey('rate', $bracket);
        }
    }

    private function assertBracketsAreProgressiveAndContiguous(mixed $brackets): void
    {
        $this->assertIsArray($brackets);
        $this->assertNotEmpty($brackets);

        $expectedFrom = 0;
        $previousRate = null;
        $lastIndex = count($brackets) - 1;

        foreach ($brackets as $index => $bracket) {
            $this->assertIsArray($bracket);

            $from = $bracket['from'];
            $to = $bracket['to'];
            $rate = $bracket['rate'];

            $this->assertSame($expectedFrom, $from);

            if ($to === null) {
                $this->assertSame($lastIndex, $index);
            } else {
                $this->assertGreaterThan($from, $to);
                $expectedFrom = $to;
            }

            $this->assertGreaterThan(0, $rate);

            if ($previousRate !== null) {
                $this->assertGreaterThanOrEqual($previousRate, $rate);
            }

            $previousRate = (float) $rate;
        }
    }

    /**
     * @return array<int, array{year: int, region: Region}>
     */
    private function supportedRegionYearPairs(): array
    {
        $pairs = [];

        foreach (self::SUPPORTED_YEARS as $year) {
            foreach (Region::cases() as $region) {
                $pairs[] = [
                    'year' => $year,
                    'region' => $region,
                ];
            }
        }

        return $pairs;
    }

    private function deleteDirectory(string $directory): void
    {
        if (! is_dir($directory)) {
            return;
        }

        $items = scandir($directory);

        if ($items === false) {
            return;
        }

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = $directory.DIRECTORY_SEPARATOR.$item;

            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }

        rmdir($directory);
    }
}

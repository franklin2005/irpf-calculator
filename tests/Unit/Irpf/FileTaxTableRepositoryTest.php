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
     * @var array<int, string>
     */
    private array $temporaryDirectories = [];

    public function test_it_loads_tax_table_for_year_and_region(): void
    {
        $repository = new FileTaxTableRepository($this->projectTaxTablesPath());

        $table = $repository->byYearAndRegion(new Year(2026), Region::Asturias);

        $this->assertArrayHasKey('state_brackets', $table);
        $this->assertArrayHasKey('regional_brackets', $table);
        $this->assertArrayHasKey('personal_minimums', $table);
        $this->assertArrayHasKey('family_minimums', $table);
        $this->assertArrayHasKey('reductions', $table);

        $this->assertBracketsSchema($table['state_brackets']);
        $this->assertBracketsSchema($table['regional_brackets']);
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

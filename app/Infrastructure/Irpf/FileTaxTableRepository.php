<?php

namespace App\Infrastructure\Irpf;

use App\Domain\Irpf\Contracts\TaxTableRepositoryInterface;
use App\Domain\Irpf\Exceptions\InvalidTaxTableSchemaException;
use App\Domain\Irpf\Exceptions\MissingTaxTableException;
use App\Domain\Irpf\ValueObjects\Region;
use App\Domain\Irpf\ValueObjects\Year;

class FileTaxTableRepository implements TaxTableRepositoryInterface
{
    public function __construct(
        private readonly ?string $basePath = null,
    ) {}

    /**
     * @return array{
     *     state_brackets: array<int, array{from: int, to: int|null, rate: float|int}>,
     *     regional_brackets: array<int, array{from: int, to: int|null, rate: float|int}>,
     *     personal_minimums: array<string, mixed>,
     *     family_minimums: array<string, mixed>,
     *     reductions: array<string, mixed>
     * }
     */
    public function byYearAndRegion(Year $year, ?Region $region = null): array
    {
        if ($region === null) {
            throw MissingTaxTableException::forRegionRequired($year->value);
        }

        $filePath = $this->resolveFilePath($year, $region);

        if (! is_file($filePath)) {
            throw MissingTaxTableException::forMissingFile($filePath);
        }

        $table = require $filePath;

        if (! is_array($table)) {
            throw InvalidTaxTableSchemaException::forInvalidRootType($filePath);
        }

        $this->assertRequiredKeys($table, $filePath);
        $this->assertBracketStructure($table['state_brackets'], 'state_brackets', $filePath);
        $this->assertBracketStructure($table['regional_brackets'], 'regional_brackets', $filePath);

        return $table;
    }

    private function resolveFilePath(Year $year, Region $region): string
    {
        return sprintf(
            '%s%s%d%s%s.php',
            $this->resolveBasePath(),
            DIRECTORY_SEPARATOR,
            $year->value,
            DIRECTORY_SEPARATOR,
            $region->value,
        );
    }

    private function resolveBasePath(): string
    {
        return rtrim($this->basePath ?? storage_path('app/tax'), DIRECTORY_SEPARATOR);
    }

    /**
     * @param  array<string, mixed>  $table
     */
    private function assertRequiredKeys(array $table, string $filePath): void
    {
        $requiredKeys = [
            'state_brackets',
            'regional_brackets',
            'personal_minimums',
            'family_minimums',
            'reductions',
        ];

        foreach ($requiredKeys as $requiredKey) {
            if (! array_key_exists($requiredKey, $table)) {
                throw InvalidTaxTableSchemaException::forMissingKey($filePath, $requiredKey);
            }
        }
    }

    private function assertBracketStructure(mixed $brackets, string $key, string $filePath): void
    {
        if (! is_array($brackets)) {
            throw InvalidTaxTableSchemaException::forMissingKey($filePath, $key);
        }

        foreach ($brackets as $index => $bracket) {
            if (! $this->isValidBracket($bracket)) {
                throw InvalidTaxTableSchemaException::forInvalidBracket(
                    $filePath,
                    $key,
                    is_int($index) ? $index : 0,
                );
            }
        }
    }

    private function isValidBracket(mixed $bracket): bool
    {
        if (! is_array($bracket)) {
            return false;
        }

        if (! array_key_exists('from', $bracket) || ! is_int($bracket['from'])) {
            return false;
        }

        if (! array_key_exists('to', $bracket) || (! is_int($bracket['to']) && $bracket['to'] !== null)) {
            return false;
        }

        if (! array_key_exists('rate', $bracket) || (! is_int($bracket['rate']) && ! is_float($bracket['rate']))) {
            return false;
        }

        return true;
    }
}

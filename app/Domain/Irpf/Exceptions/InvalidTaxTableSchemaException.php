<?php

namespace App\Domain\Irpf\Exceptions;

use RuntimeException;

class InvalidTaxTableSchemaException extends RuntimeException
{
    public static function forInvalidRootType(string $filePath): self
    {
        return new self("El archivo de tabla fiscal debe devolver un array: {$filePath}");
    }

    public static function forMissingKey(string $filePath, string $key): self
    {
        return new self("El archivo de tabla fiscal no tiene la clave requerida [{$key}]: {$filePath}");
    }

    public static function forInvalidBracket(string $filePath, string $key, int $index): self
    {
        return new self("El tramo fiscal [{$key}.{$index}] tiene un esquema inválido: {$filePath}");
    }
}

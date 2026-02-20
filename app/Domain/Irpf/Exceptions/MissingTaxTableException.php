<?php

namespace App\Domain\Irpf\Exceptions;

use RuntimeException;

class MissingTaxTableException extends RuntimeException
{
    public static function forRegionRequired(int $year): self
    {
        return new self("Es necesario especificar una región para obtener la tabla de impuestos del año {$year}.");
    }

    public static function forMissingFile(string $filePath): self
    {
        return new self("Archivo no encontrado: {$filePath}");
    }
}

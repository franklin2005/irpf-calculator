<?php

namespace App\Domain\Irpf\ValueObjects;

final readonly class Money
{
    public function __construct(public int $cents) {}

    public static function zero(): self
    {
        return new self(0);
    }
}

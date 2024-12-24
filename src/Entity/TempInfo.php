<?php
declare(strict_types=1);

namespace Flynn314\SeaTemperature\Entity;

final readonly class TempInfo
{
    public function __construct(
        private float  $temp,
        private string $description
    ) {}

    public function getTemp(): float
    {
        return $this->temp;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

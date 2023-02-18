<?php
declare(strict_types=1);

namespace Flynn314\SeaTemperature\Entity;

final class TempInfo
{
    private float $temp;
    private string $description;

    public function __construct(float $temp, string $description)
    {
        $this->temp = $temp;
        $this->description = $description;
    }

    public function getTemp(): float
    {
        return $this->temp;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

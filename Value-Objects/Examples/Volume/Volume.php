<?php

namespace ValueObjects\Examples\Volume;

/**
 * Volume is a Value Object representing a physical volume with a unit.
 */
final class Volume
{
    private float $value;
    private string $unit;

    public function __construct(float $value, string $unit)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException("Volume cannot be negative.");
        }
        if (!in_array($unit, ['l', 'ml', 'gal', 'pt'])) {
            throw new \InvalidArgumentException("Invalid volume unit: " . $unit);
        }

        $this->value = $value;
        $this->unit = $unit;
    }

    public function getValue(): float { return $this->value; }
    public function getUnit(): string { return $this->unit; }

    public function toMilliliters(): float
    {
        switch ($this->unit) {
            case 'l': return $this->value * 1000;
            case 'ml': return $this->value;
            case 'gal': return $this->value * 3785.41;
            case 'pt': return $this->value * 473.176;
            default: throw new \LogicException("Unit not handled.");
        }
    }

    public function equals(Volume $other): bool
    {
        return $this->toMilliliters() === $other->toMilliliters();
    }
}

<?php

namespace ValueObjects\Examples\Weight;

/**
 * Weight is a Value Object representing a physical weight with a unit.
 */
final class Weight
{
    private float $value;
    private string $unit;

    public function __construct(float $value, string $unit)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException("Weight cannot be negative.");
        }
        if (!in_array($unit, ['kg', 'g', 'lb', 'oz'])) {
            throw new \InvalidArgumentException("Invalid weight unit: " . $unit);
        }

        $this->value = $value;
        $this->unit = $unit;
    }

    public function getValue(): float { return $this->value; }
    public function getUnit(): string { return $this->unit; }

    public function toGrams(): float
    {
        switch ($this->unit) {
            case 'kg': return $this->value * 1000;
            case 'g': return $this->value;
            case 'lb': return $this->value * 453.592;
            case 'oz': return $this->value * 28.3495;
            default: throw new \LogicException("Unit not handled.");
        }
    }

    public function equals(Weight $other): bool
    {
        return $this->toGrams() === $other->toGrams();
    }

    public function add(Weight $other): Weight
    {
        return new Weight($this->value + ($other->toGrams() / $this->conversionFactor()), $this->unit);
    }

    private function conversionFactor(): float
    {
        switch ($this->unit) {
            case 'kg': return 1000;
            case 'g': return 1;
            case 'lb': return 453.592;
            case 'oz': return 28.3495;
            default: return 1;
        }
    }
}

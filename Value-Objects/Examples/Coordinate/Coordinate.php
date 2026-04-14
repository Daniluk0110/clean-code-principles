<?php

namespace ValueObjects\Examples\Coordinate;

/**
 * Coordinate is a Value Object representing a point on a 2D plane.
 */
final class Coordinate
{
    private float $latitude;
    private float $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        if ($latitude < -90 || $latitude > 90) {
            throw new \InvalidArgumentException("Invalid latitude: must be between -90 and 90.");
        }
        if ($longitude < -180 || $longitude > 180) {
            throw new \InvalidArgumentException("Invalid longitude: must be between -180 and 180.");
        }

        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): float { return $this->latitude; }
    public function getLongitude(): float { return $this->longitude; }

    public function equals(Coordinate $other): bool
    {
        return $this->latitude === $other->latitude && 
               $this->longitude === $other->longitude;
    }

    public function __toString(): string
    {
        return sprintf("(%f, %f)", $this->latitude, $this->longitude);
    }
}

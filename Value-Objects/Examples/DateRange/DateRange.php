<?php

namespace ValueObjects\Examples\DateRange;

/**
 * DateRange is a Value Object representing a period between two dates.
 */
final class DateRange
{
    private \DateTimeImmutable $startDate;
    private \DateTimeImmutable $endDate;

    public function __construct(\DateTimeImmutable $startDate, \DateTimeImmutable $endDate)
    {
        if ($startDate > $endDate) {
            throw new \InvalidArgumentException("Start date cannot be after end date.");
        }

        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getStartDate(): \DateTimeImmutable { return $this->startDate; }
    public function getEndDate(): \DateTimeImmutable { return $this->endDate; }

    public function includes(\DateTimeImmutable $date): bool
    {
        return $date >= $this->startDate && $date <= $this->endDate;
    }

    public function getDurationInDays(): int
    {
        return $this->startDate->diff($this->endDate)->days;
    }

    public function equals(DateRange $other): bool
    {
        return $this->startDate == $other->startDate && 
               $this->endDate == $other->endDate;
    }
}

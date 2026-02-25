<?php

declare(strict_types=1);

interface DiscountStrategyInterface
{
    public function apply(float $amount): float;
}

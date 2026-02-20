<?php

declare(strict_types=1);

final class Money
{
    public function __construct(public int $cents, public string $currency) {}

    public function multiply(float $factor): self
    {
        return new self((int) round($this->cents * $factor), $this->currency);
    }
}

class BaseModel {}

class User extends BaseModel
{
    protected Money $basePrice;

    public function __construct(Money $basePrice)
    {
        $this->basePrice = $basePrice;
    }

    public function getPrice(): Money
    {
        return $this->basePrice;
    }
}

class PremiumUser extends User
{
    public function getPrice(): Money
    {
        return $this->basePrice->multiply(0.9);
    }
}

// ✅ С композицией
interface PricingStrategyInterface
{
    public function calculate(Money $basePrice): Money;
}

final class RegularPricing implements PricingStrategyInterface
{
    public function calculate(Money $basePrice): Money
    {
        return $basePrice;
    }
}

final class PremiumPricing implements PricingStrategyInterface
{
    public function calculate(Money $basePrice): Money
    {
        return $basePrice->multiply(0.9);
    }
}

final class CorporatePricing implements PricingStrategyInterface
{
    public function calculate(Money $basePrice): Money
    {
        return $basePrice->multiply(0.8);
    }
}

final class UserWithStrategy
{
    public function __construct(private Money $basePrice, private PricingStrategyInterface $strategy) {}

    public function getPrice(): Money
    {
        return $this->strategy->calculate($this->basePrice);
    }
}

$basePrice = new Money(10000, 'USD');

$regular = new UserWithStrategy($basePrice, new RegularPricing());
$premium = new UserWithStrategy($basePrice, new PremiumPricing());
$corporate = new UserWithStrategy($basePrice, new CorporatePricing());

echo $regular->getPrice()->cents . PHP_EOL;
echo $premium->getPrice()->cents . PHP_EOL;
echo $corporate->getPrice()->cents . PHP_EOL;

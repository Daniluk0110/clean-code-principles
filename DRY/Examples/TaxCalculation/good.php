<?php

declare(strict_types=1);

final class TaxCalculator
{
    public function calculateTotal(float $subtotal, float $discountPercent, string $countryCode): float
    {
        $discounted = $subtotal - ($subtotal * $discountPercent / 100);
        $vatRate = $this->vatRateByCountry($countryCode);
        $vat = $discounted * $vatRate;

        if ($discounted > 500) {
            $vat -= 5;
        }

        return round($discounted + $vat, 2);
    }

    private function vatRateByCountry(string $countryCode): float
    {
        return match ($countryCode) {
            'DE' => 0.19,
            'PL' => 0.23,
            'FR' => 0.20,
            default => 0.21,
        };
    }
}

final class OrderService
{
    public function __construct(private TaxCalculator $taxCalculator)
    {
    }

    public function calculateTotal(float $subtotal, float $discountPercent, string $countryCode): float
    {
        return $this->taxCalculator->calculateTotal($subtotal, $discountPercent, $countryCode);
    }
}

final class SubscriptionService
{
    public function __construct(private TaxCalculator $taxCalculator)
    {
    }

    public function calculateTotal(float $subtotal, float $discountPercent, string $countryCode): float
    {
        return $this->taxCalculator->calculateTotal($subtotal, $discountPercent, $countryCode);
    }
}

$taxCalculator = new TaxCalculator();
$orderService = new OrderService($taxCalculator);
$subscriptionService = new SubscriptionService($taxCalculator);

$checkoutTotal = $orderService->calculateTotal(1200, 10, 'DE');
$subscriptionTotal = $subscriptionService->calculateTotal(29.99, 5, 'PL');

echo "Order total: {$checkoutTotal}\n";
echo "Subscription total: {$subscriptionTotal}\n";

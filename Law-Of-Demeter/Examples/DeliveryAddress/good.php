<?php

declare(strict_types=1);

final class Address
{
    public function __construct(private string $zipCode)
    {
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }
}

final class Profile
{
    public function __construct(private Address $billingAddress)
    {
    }

    public function getBillingZipCode(): string
    {
        return $this->billingAddress->getZipCode();
    }
}

final class Customer
{
    public function __construct(private Profile $profile)
    {
    }

    public function getBillingZipCode(): string
    {
        return $this->profile->getBillingZipCode();
    }
}

final class Order
{
    public function __construct(private Customer $customer)
    {
    }

    public function getBillingZipCode(): string
    {
        return $this->customer->getBillingZipCode();
    }
}

$order = new Order(
    new Customer(
        new Profile(
            new Address('10115')
        )
    )
);

$zip = $order->getBillingZipCode();

echo "ZIP: {$zip}\n";

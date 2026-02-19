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

    public function getBillingAddress(): Address
    {
        return $this->billingAddress;
    }
}

final class Customer
{
    public function __construct(private Profile $profile)
    {
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }
}

final class Order
{
    public function __construct(private Customer $customer)
    {
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}

$order = new Order(
    new Customer(
        new Profile(
            new Address('10115')
        )
    )
);

$zip = $order->getCustomer()
    ->getProfile()
    ->getBillingAddress()
    ->getZipCode();

echo "ZIP: {$zip}\n";

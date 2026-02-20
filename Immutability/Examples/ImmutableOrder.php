<?php

declare(strict_types=1);

enum OrderStatus: string
{
    case New = 'new';
    case Paid = 'paid';
    case Shipped = 'shipped';
}

readonly class Money
{
    public function __construct(
        public string $currency,
        public int $cents
    ) {}
}

readonly class Address
{
    public function __construct(
        public string $street,
        public string $city
    ) {}
}

readonly class OrderSnapshot
{
    public function __construct(
        public int $id,
        public OrderStatus $status,
        public Money $amount,
        public Address $deliveryAddress
    ) {}

    public function withStatus(OrderStatus $status): self
    {
        return new self($this->id, $status, $this->amount, $this->deliveryAddress);
    }

    public function withDeliveryAddress(Address $address): self
    {
        return new self($this->id, $this->status, $this->amount, $address);
    }
}

$original = new OrderSnapshot(
    1002,
    OrderStatus::New,
    new Money('USD', 15000),
    new Address('Main St 10', 'Austin')
);

$paid = $original->withStatus(OrderStatus::Paid);
$moved = $paid->withDeliveryAddress(new Address('Market St 1', 'Austin'));

echo $original->status->value . PHP_EOL; // new
echo $paid->status->value . PHP_EOL;     // paid
echo $moved->deliveryAddress->street . PHP_EOL; // Market St 1

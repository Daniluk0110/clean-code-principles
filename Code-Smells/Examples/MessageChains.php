<?php

namespace CodeSmells\Examples;

class MessageChains
{
    /**
     * Shows Law of Demeter violation (Message Chains).
     */
    public function getCustomerZipCode(Order $order): string
    {
        // Long chain of calls
        return $order->getCustomer()->getProfile()->getAddress()->getZipCode();
    }
}

class Order {
    public function getCustomer() { return new Customer(); }
}

class Customer {
    public function getProfile() { return new Profile(); }
}

class Profile {
    public function getAddress() { return new Address(); }
}

class Address {
    public function getZipCode() { return "12345"; }
}

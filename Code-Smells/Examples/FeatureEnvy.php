<?php

namespace CodeSmells\Examples;

class FeatureEnvy
{
    /**
     * This method shows Feature Envy because it's more interested in the 
     * User's properties than its own class.
     */
    public function formatUserAddress(User $user): string
    {
        $address = $user->getStreet() . ", " .
                   $user->getCity() . ", " .
                   $user->getState() . " " .
                   $user->getZipCode() . "\n" .
                   $user->getCountry();
        
        return $address;
    }
}

class User
{
    private string $street;
    private string $city;
    private string $state;
    private string $zipCode;
    private string $country;

    public function getStreet(): string { return $this->street; }
    public function getCity(): string { return $this->city; }
    public function getState(): string { return $this->state; }
    public function getZipCode(): string { return $this->zipCode; }
    public function getCountry(): string { return $this->country; }
}

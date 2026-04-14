<?php

namespace DRY\Examples\Validation;

class Validator
{
    public static function validateUserData(array $data): void
    {
        if (empty($data['username'])) {
            throw new \Exception("Username is required");
        }
        if (strlen($data['username']) < 3) {
            throw new \Exception("Username must be at least 3 characters");
        }

        if (empty($data['email'])) {
            throw new \Exception("Email is required");
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Invalid email format");
        }
    }
}

class UserRegistration
{
    public function register(array $data): void
    {
        Validator::validateUserData($data);
        // ... registration logic
    }
}

class UserProfileUpdate
{
    public function update(array $data): void
    {
        Validator::validateUserData($data);
        // ... update logic
    }
}

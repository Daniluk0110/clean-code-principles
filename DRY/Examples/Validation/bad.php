<?php

namespace DRY\Examples\Validation;

class UserRegistration
{
    public function register(array $data): void
    {
        // Duplicate validation logic
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

        // ... registration logic
    }
}

class UserProfileUpdate
{
    public function update(array $data): void
    {
        // Identical validation logic repeated here
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

        // ... update logic
    }
}

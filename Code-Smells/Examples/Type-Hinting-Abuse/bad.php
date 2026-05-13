<?php

declare(strict_types=1);

final class UserRegistration
{
    /**
     * @param array $userData Ожидается: ['name' => string, 'email' => string, 'age' => int]
     */
    public function register(array $userData): void
    {
        if (!isset($userData['email']) || !isset($userData['name'])) {
            throw new InvalidArgumentException('Missing required fields: email and name');
        }

        $email = $userData['email'];
        $name = $userData['name'];
        $age = $userData['age'] ?? 18;

        // Логика регистрации...
    }
}

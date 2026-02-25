<?php

declare(strict_types=1);

final class RegistrationService implements UserRegistratorInterface
{
    public function register(string $email, string $password): string
    {
        // В обычном приложении тут хеширование, валидация, запись.
        return hash('sha256', $email . $password);
    }
}

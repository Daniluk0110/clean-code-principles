<?php

declare(strict_types=1);

final readonly class UserRegistrationDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public int $age = 18,
    ) {}
}

final class UserRegistration
{
    public function register(UserRegistrationDTO $dto): void
    {
        // Не нужно проверять isset(), типы и наличие свойств гарантированы PHP
        $name = $dto->name;
        $email = $dto->email;
        $age = $dto->age;

        // Логика регистрации...
    }
}

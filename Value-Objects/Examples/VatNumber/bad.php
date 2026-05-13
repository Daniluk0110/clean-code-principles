<?php

declare(strict_types=1);

final class CompanyRegistrationService
{
    public function register(string $companyName, string $vatNumber): void
    {
        // Валидация размазана по сервисам
        if (trim($vatNumber) === '') {
            throw new InvalidArgumentException('VAT number cannot be empty');
        }

        if (!preg_match('/^[A-Z]{2}[0-9A-Z]{2,12}$/', $vatNumber)) {
            throw new InvalidArgumentException('Invalid VAT number format');
        }

        // Регистрация компании...
    }
}

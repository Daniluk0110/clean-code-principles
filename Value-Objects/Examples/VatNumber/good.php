<?php

declare(strict_types=1);

final class VatNumber
{
    public function __construct(private string $value)
    {
        $this->value = strtoupper(trim($value));

        if ($this->value === '') {
            throw new DomainException('VAT number cannot be empty');
        }

        if (!preg_match('/^[A-Z]{2}[0-9A-Z]{2,12}$/', $this->value)) {
            throw new DomainException('Invalid VAT number format');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getCountryCode(): string
    {
        return substr($this->value, 0, 2);
    }
}

final class CompanyRegistrationService
{
    // Сигнатура метода сама говорит: дай мне валидный VAT!
    public function register(string $companyName, VatNumber $vatNumber): void
    {
        // Не нужно никаких проверок!
        // Можно сразу использовать методы бизнес-логики:
        $country = $vatNumber->getCountryCode();

        // Регистрация компании...
    }
}

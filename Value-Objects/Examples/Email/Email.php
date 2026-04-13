<?php

declare(strict_types=1);

final class Email
{
    public function __construct(public private(set) string $value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Invalid email address: ' . $value . '.');
        }
    }

    public function getDomain(): string
    {
        $parts = explode('@', $this->value);

        return $parts[1] ?? '';
    }

    public function equals(Email $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

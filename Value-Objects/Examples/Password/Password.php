<?php

namespace ValueObjects\Examples\Password;

/**
 * Password is a Value Object that encapsulates password complexity and security.
 */
final class Password
{
    private string $hashedValue;

    public function __construct(string $plainPassword)
    {
        if (strlen($plainPassword) < 8) {
            throw new \InvalidArgumentException("Password must be at least 8 characters long.");
        }
        if (!preg_match('/[A-Z]/', $plainPassword)) {
            throw new \InvalidArgumentException("Password must contain at least one uppercase letter.");
        }
        if (!preg_match('/[0-9]/', $plainPassword)) {
            throw new \InvalidArgumentException("Password must contain at least one number.");
        }

        $this->hashedValue = password_hash($plainPassword, PASSWORD_DEFAULT);
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedValue);
    }

    public function getHashedValue(): string
    {
        return $this->hashedValue;
    }
}

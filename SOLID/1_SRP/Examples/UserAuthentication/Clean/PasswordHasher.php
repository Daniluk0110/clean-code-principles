<?php

namespace SOLID\SRP\Examples\UserAuthentication\Clean;

class PasswordHasher
{
    /**
     * Follows SRP: only handles password hashing.
     */
    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}

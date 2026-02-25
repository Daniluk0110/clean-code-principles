<?php

declare(strict_types=1);

interface UserRegistratorInterface
{
    public function register(string $email, string $password): string;
}

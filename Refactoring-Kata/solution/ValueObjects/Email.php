<?php

declare(strict_types=1);

namespace RefactoringKata\ValueObjects;

final class Email
{
    public function __construct(public readonly string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email.');
        }
    }
}

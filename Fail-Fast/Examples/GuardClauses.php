<?php

declare(strict_types=1);

final class Guard
{
    public static function notNull(mixed $value, string $field): void
    {
        if ($value === null) {
            throw new InvalidArgumentException("Field '{$field}' must not be null.");
        }
    }

    public static function positiveInt(int $value, string $field): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("Field '{$field}' must be a positive integer, got: {$value}");
        }
    }

    public static function notEmpty(string $value, string $field): void
    {
        if ($value === '') {
            throw new InvalidArgumentException("Field '{$field}' must not be empty.");
        }
    }

    public static function inArray(mixed $value, array $allowed, string $field): void
    {
        if (!in_array($value, $allowed, true)) {
            $allowedList = implode(', ', array_map(static fn (mixed $item): string => (string) $item, $allowed));
            $valueText = is_scalar($value) ? (string) $value : gettype($value);

            throw new InvalidArgumentException(
                "Field '{$field}' must be one of: [{$allowedList}], got: {$valueText}"
            );
        }
    }
}

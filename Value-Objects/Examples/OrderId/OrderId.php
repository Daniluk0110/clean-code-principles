<?php

declare(strict_types=1);

final class OrderId
{
    private const UUID_V4_PATTERN = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

    private function __construct(public private(set) string $value)
    {
    }

    public static function generate(): self
    {
        $bytes = random_bytes(16);

        $bytes[6] = chr((ord($bytes[6]) & 0x0f) | 0x40);
        $bytes[8] = chr((ord($bytes[8]) & 0x3f) | 0x80);

        $hex = bin2hex($bytes);

        $uuid = sprintf(
            '%s-%s-%s-%s-%s',
            substr($hex, 0, 8),
            substr($hex, 8, 4),
            substr($hex, 12, 4),
            substr($hex, 16, 4),
            substr($hex, 20, 12)
        );

        return new self($uuid);
    }

    public static function fromString(string $value): self
    {
        if (!preg_match(self::UUID_V4_PATTERN, $value)) {
            throw new InvalidArgumentException('Invalid UUID v4: ' . $value . '.');
        }

        return new self(strtolower($value));
    }
}

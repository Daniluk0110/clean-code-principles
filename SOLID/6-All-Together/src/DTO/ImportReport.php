<?php

declare(strict_types=1);

final class ImportReport
{
    /** @var array<string, string[]> */
    private array $errors = [];

    public function __construct(
        public int $imported = 0,
        public int $skipped = 0,
    ) {}

    /**
     * @param string[] $messages
     */
    public function addError(string $sku, array $messages): void
    {
        $this->errors[$sku] = $messages;
    }

    /**
     * @return array<string, string[]>
     */
    public function errors(): array
    {
        return $this->errors;
    }
}

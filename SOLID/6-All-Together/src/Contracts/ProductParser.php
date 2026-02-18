<?php

declare(strict_types=1);

interface ProductParser
{
    /**
     * @return Product[]
     */
    public function parse(string $raw): array;
}

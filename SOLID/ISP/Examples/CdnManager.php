<?php

declare(strict_types=1);

interface CdnManager
{
    public function setupCDN(string $domain): void;
}

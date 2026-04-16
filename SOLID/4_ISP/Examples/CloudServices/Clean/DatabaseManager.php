<?php

declare(strict_types=1);

interface DatabaseManager
{
    public function manageDatabase(string $dbName): void;
}

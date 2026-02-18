<?php

declare(strict_types=1);

require_once __DIR__ . '/DatabaseInterface.php';

final class MySQLDatabase implements DatabaseInterface
{
    public function fetchUserById(int $id): array
    {
        return ['id' => $id, 'name' => 'Jane'];
    }
}

<?php

declare(strict_types=1);

require_once __DIR__ . '/MySQLDatabase.php';
require_once __DIR__ . '/UserService.php';

final class Container
{
    public function userService(): UserService
    {
        $database = new MySQLDatabase();

        return new UserService($database);
    }
}

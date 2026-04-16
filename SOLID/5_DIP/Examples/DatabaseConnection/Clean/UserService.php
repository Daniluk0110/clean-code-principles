<?php

declare(strict_types=1);

require_once __DIR__ . '/DatabaseInterface.php';

final class UserService
{
    public function __construct(private DatabaseInterface $db) {}

    public function getUser(int $id): array
    {
        return $this->db->fetchUserById($id);
    }
}

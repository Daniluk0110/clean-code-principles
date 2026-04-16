<?php

declare(strict_types=1);

final class MySQLDatabase
{
    public function fetchUserById(int $id): array
    {
        // Эмуляция запроса к БД
        return ['id' => $id, 'name' => 'Jane'];
    }
}

final class UserService
{
    private MySQLDatabase $db;

    public function __construct()
    {
        // ЖЕСТКАЯ ЗАВИСИМОСТЬ: Сервис сам создает подключение к MySQL
        $this->db = new MySQLDatabase();
    }

    public function getUser(int $id): array
    {
        return $this->db->fetchUserById($id);
    }
}

$service = new UserService();
$user = $service->getUser(1);
print_r($user);

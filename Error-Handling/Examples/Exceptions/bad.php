<?php

declare(strict_types=1);

namespace ErrorHandling\Examples\Exceptions\Bad;

final class UserRepository
{
    /**
     * Возвращает пользователя или null, если он не найден.
     * Проблема: вызывающий код обязан делать проверку на null.
     */
    public function findById(int $id): ?array
    {
        // Симуляция базы данных
        $users = [
            1 => ['id' => 1, 'name' => 'Alice'],
        ];

        return $users[$id] ?? null;
    }
}

final class UserService
{
    public function __construct(private UserRepository $repository) {}

    public function getUserName(int $id): string
    {
        $user = $this->repository->findById($id);

        // Мы вынуждены проверять на null здесь и в любом другом месте,
        // где вызывается findById. Это раздувает код.
        if ($user === null) {
            return 'Guest';
        }

        return $user['name'];
    }
}

$service = new UserService(new UserRepository());
echo $service->getUserName(1) . PHP_EOL;
echo $service->getUserName(999) . PHP_EOL;

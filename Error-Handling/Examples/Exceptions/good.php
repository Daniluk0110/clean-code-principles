<?php

declare(strict_types=1);

namespace ErrorHandling\Examples\Exceptions\Good;

use RuntimeException;

/**
 * Кастомное исключение делает ошибку семантически понятной.
 */
final class UserNotFoundException extends RuntimeException
{
    public static function forId(int $id): self
    {
        return new self("User with ID {$id} not found.");
    }
}

final class UserRepository
{
    /**
     * Выбрасывает исключение, если пользователь не найден.
     * Это гарантирует, что если метод вернул управление, пользователь точно существует.
     */
    public function getById(int $id): array
    {
        $users = [
            1 => ['id' => 1, 'name' => 'Alice'],
        ];

        if (!isset($users[$id])) {
            throw UserNotFoundException::forId($id);
        }

        return $users[$id];
    }
}

final class UserService
{
    public function __construct(private UserRepository $repository) {}

    public function getUserName(int $id): string
    {
        try {
            $user = $this->repository->getById($id);
            return $user['name'];
        } catch (UserNotFoundException) {
            // Обработка конкретной ситуации в одном месте.
            // Бизнес-логика остается чистой.
            return 'Guest';
        }
    }
}

$service = new UserService(new UserRepository());
echo $service->getUserName(1) . PHP_EOL;
echo $service->getUserName(999) . PHP_EOL;

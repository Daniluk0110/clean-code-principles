<?php

declare(strict_types=1);

namespace SideEffects\Examples\HiddenSideEffects\Bad;

final class AuthService
{
    /**
     * Проблема: Метод называется "check", что подразумевает только запрос (Query).
     * Однако внутри он скрыто обновляет дату входа (Command).
     * Пользователь метода не ожидает, что простая проверка пароля изменит данные в БД.
     */
    public function checkPassword(string $email, string $password): bool
    {
        $user = $this->findUserByEmail($email);

        if ($password !== $user['password']) {
            return false;
        }

        // СКРЫТЫЙ ПОБОЧНЫЙ ЭФФЕКТ:
        $this->updateLastLogin($email);

        return true;
    }

    private function findUserByEmail(string $email): array
    {
        return ['password' => 'secret123'];
    }

    private function updateLastLogin(string $email): void
    {
        echo "Updating last login for {$email}..." . PHP_EOL;
    }
}

$auth = new AuthService();
// Мы просто хотим проверить пароль, но база данных обновится.
$auth->checkPassword('user@example.com', 'secret123');

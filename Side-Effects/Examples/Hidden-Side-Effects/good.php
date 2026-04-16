<?php

declare(strict_types=1);

namespace SideEffects\Examples\HiddenSideEffects\Good;

final class AuthService
{
    /**
     * Теперь метод делает только то, что заявлено в названии: проверяет пароль.
     */
    public function checkPassword(string $email, string $password): bool
    {
        $user = $this->findUserByEmail($email);

        return $password === $user['password'];
    }

    /**
     * Побочный эффект вынесен в отдельный, явно названный метод.
     */
    public function recordLogin(string $email): void
    {
        echo "Updating last login for {$email}..." . PHP_EOL;
    }

    private function findUserByEmail(string $email): array
    {
        return ['password' => 'secret123'];
    }
}

// Теперь вызывающий код полностью контролирует ситуацию:
$auth = new AuthService();
$email = 'user@example.com';

if ($auth->checkPassword($email, 'secret123')) {
    // Мы явно решаем, когда вызвать побочный эффект.
    $auth->recordLogin($email);
}

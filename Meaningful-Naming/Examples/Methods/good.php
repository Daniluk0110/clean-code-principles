<?php

declare(strict_types=1);

namespace MeaningfulNaming\Examples\Methods\Good;

final class User
{
    private bool $isActive = true;

    /**
     * Имя метода — глагол. Сразу понятно действие.
     */
    public function updateProfile(array $data): void
    {
        // ...
    }

    /**
     * Позитивное именование предикатов. 
     * Код читается естественно.
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }
}

$user = new User();
if ($user->isActive()) {
    // "Если пользователь активен..." — просто и понятно.
}

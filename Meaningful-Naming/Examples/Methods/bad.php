<?php

declare(strict_types=1);

namespace MeaningfulNaming\Examples\Methods\Bad;

final class User
{
    private bool $isNotActive = false;

    /**
     * Проблема: Имя метода не является глаголом. 
     * Непонятно, что именно делает этот метод.
     */
    public function data(array $data): void
    {
        // ...
    }

    /**
     * Проблема: Двойное отрицание. 
     * !isNotActive() — это сложно для понимания с первого взгляда.
     */
    public function isNotActive(): bool
    {
        return $this->isNotActive;
    }
}

$user = new User();
if (!$user->isNotActive()) {
    // "Если НЕ пользователь НЕ активен..." — это выносит мозг.
}

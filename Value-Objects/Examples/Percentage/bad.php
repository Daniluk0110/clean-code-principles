<?php

declare(strict_types=1);

final class DiscountService
{
    /**
     * @param float $discount Процент скидки (непонятно, передавать 20 или 0.2?)
     */
    public function applyDiscount(float $price, float $discount): float
    {
        // Приходится валидировать везде, где используется процент
        if ($discount < 0 || $discount > 100) {
            throw new InvalidArgumentException('Скидка должна быть от 0 до 100');
        }

        // Если передали 20, нужно поделить на 100, а вдруг передали уже 0.2?
        return $price - ($price * ($discount / 100));
    }
}

<?php

declare(strict_types=1);

final class BankAccount
{
    private float $balance = 1000.0;

    public function withdraw(float $amount): void
    {
        if ($amount > $this->balance) {
            // Выбрасываем стандартное исключение с текстом
            throw new Exception('Недостаточно средств');
        }

        if ($amount <= 0) {
            throw new Exception('Сумма должна быть больше нуля');
        }

        $this->balance -= $amount;
    }
}

// Контроллер
final class PaymentController
{
    public function handle(BankAccount $account): void
    {
        try {
            $account->withdraw(2000.0);
        } catch (Exception $e) {
            // Мы не знаем точно, это ошибка бизнес-логики (недостаточно средств)
            // или упала база данных (PDOException). Приходится смотреть на текст.
            if ($e->getMessage() === 'Недостаточно средств') {
                echo "Ошибка валидации платежа: " . $e->getMessage();
                return;
            }

            // Иначе это системная ошибка (500)
            echo "Внутренняя ошибка сервера";
        }
    }
}

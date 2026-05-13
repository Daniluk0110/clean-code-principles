<?php

declare(strict_types=1);

// Создаем доменные исключения
abstract class DomainException extends Exception {}

final class InsufficientFundsException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Недостаточно средств на балансе');
    }
}

final class InvalidAmountException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Сумма операции должна быть больше нуля');
    }
}

final class BankAccount
{
    private float $balance = 1000.0;

    public function withdraw(float $amount): void
    {
        if ($amount > $this->balance) {
            throw new InsufficientFundsException();
        }

        if ($amount <= 0) {
            throw new InvalidAmountException();
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
        } catch (DomainException $e) {
            // Мы точно знаем, что это бизнес-ошибка (422 или 400)
            echo "Ошибка валидации: " . $e->getMessage();
        } catch (Exception $e) {
            // Любая другая непредсказуемая ошибка системы (500)
            // PDOException, RedisException и т.д.
            echo "Внутренняя ошибка сервера";
        }
    }
}

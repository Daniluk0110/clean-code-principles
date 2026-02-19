# SRP — Single Responsibility Principle 🧩

**Расшифровка (EN):** Single Responsibility Principle.  
**Расшифровка (RU):** Принцип единственной ответственности.

**Суть:** у класса должна быть одна причина для изменения — одна четкая зона ответственности. ✅

**Почему важно:** маленькие, сфокусированные классы проще тестировать, расширять и менять без побочных эффектов. 💡

## Теория простыми словами 📌
- Ответственность — это изменяемость по одной причине, а не один метод.
- Если требования меняются в двух разных сценариях, это уже две ответственности.
- Чем четче границы, тем легче поддержка и переиспользование.

## Как распознать границы 🧭
- Изменения в логировании не должны ломать бизнес-логику.
- Изменения в уведомлениях не должны трогать расчет итогов.
- Отдельные причины — отдельные классы.

## Запахи кода 👃
- Класс делает «всё подряд»: бизнес‑логика + логирование + отправка уведомлений.
- Слишком много причин для изменения в одном файле.
- Много разных зависимостей и несвязанных методов.
- Тесты требуют сложных стабов/моков из‑за перегруженности класса.

## Было (Плохо) ❌
```php
<?php

declare(strict_types=1);

final class OrderProcessor
{
    public function process(array $items, string $email): void
    {
        $total = 0.0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $this->log("Order total: {$total}");
        $this->sendEmail($email, $total);
    }

    private function log(string $message): void
    {
        file_put_contents('orders.log', $message . PHP_EOL, FILE_APPEND);
    }

    private function sendEmail(string $email, float $total): void
    {
        file_put_contents('mail.log', "Email to {$email}: total {$total}" . PHP_EOL, FILE_APPEND);
    }
}
```

## Стало (Хорошо) ✅
```php
<?php

declare(strict_types=1);

final class OrderTotalCalculator
{
    public function calculate(array $items): float
    {
        $total = 0.0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return $total;
    }
}

final class OrderLogger
{
    public function logTotal(float $total): void
    {
        file_put_contents('orders.log', "Order total: {$total}" . PHP_EOL, FILE_APPEND);
    }
}

final class ReceiptEmailSender
{
    public function send(string $email, float $total): void
    {
        file_put_contents('mail.log', "Email to {$email}: total {$total}" . PHP_EOL, FILE_APPEND);
    }
}

final class OrderProcessor
{
    public function __construct(
        private OrderTotalCalculator $calculator,
        private OrderLogger $logger,
        private ReceiptEmailSender $sender,
    ) {}

    public function process(array $items, string $email): void
    {
        $total = $this->calculator->calculate($items);
        $this->logger->logTotal($total);
        $this->sender->send($email, $total);
    }
}
```

## Пример мини‑системы (Examples/) 🧪
В папке `Examples/` лежат 4 файла с полностью рабочим примером без фреймворков:
- `OrderTotalCalculator.php`
- `OrderLogger.php`
- `ReceiptEmailSender.php`
- `index.php`

Запуск:
```bash
php index.php
```

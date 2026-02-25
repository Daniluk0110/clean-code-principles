<?php

declare(strict_types=1);

require __DIR__ . '/OrderTotalCalculator.php';
require __DIR__ . '/OrderDatabaseSaver.php';
require __DIR__ . '/OrderLogger.php';
require __DIR__ . '/OrderEmailSender.php';
require __DIR__ . '/OrderProcessor.php';

/*
 * Вот как выглядел старый жирный класс, нарушавший SRP:
 *
 * final class OrderManager
 * {
 *     public function process(array $items, string $customerEmail): void
 *     {
 *         $total = 0;
 *         foreach ($items as $item) {
 *             $total += $item['price'] * $item['quantity'];
 *         }
 *
 *         $payload = [
 *             'id' => bin2hex(random_bytes(5)),
 *             'items' => $items,
 *             'total' => $total,
 *             'created_at' => (new DateTimeImmutable())->format(DATE_ATOM),
 *         ];
 *
 *         file_put_contents('orders.json', json_encode($payload, JSON_PRETTY_PRINT));
 *         file_put_contents('log.txt', "Заказ сохранён: {$payload['id']}\n", FILE_APPEND);
 *         mail($customerEmail, 'Ваш заказ', 'Платёж прошёл успешно');
 *     }
 * }
 *
 * Такой класс меняется по четырём разным причинам: изменение расчёта суммы, логики сохранения, логирования или отправки чека.
 *
 * А вот как правильно — OrderProcessor, OrderTotalCalculator, OrderDatabaseSaver, OrderLogger и
 * OrderEmailSender меняются только тогда, когда затрагивается их единственная зона ответственности.
 *
 * Запуск: php index.php
 */

$items = [
    ['name' => 'SSD 2TB', 'price' => 120.00, 'quantity' => 1],
    ['name' => 'Разъём USB-C', 'price' => 9.50, 'quantity' => 2],
    ['name' => 'Кабель питания 1.8 м', 'price' => 6.75, 'quantity' => 3],
];

$storagePath = __DIR__ . '/separated-orders.json';

$calculator = new OrderTotalCalculator();
$saver = new OrderDatabaseSaver($storagePath);
$logger = new OrderLogger();
$emailSender = new OrderEmailSender();

$processor = new OrderProcessor($calculator, $saver, $logger, $emailSender);
$result = $processor->process($items, 'alex@company.local');

printf("Сформирован заказ %s. Общая сумма: %.2f.\n", $result['orderId'], $result['total']);

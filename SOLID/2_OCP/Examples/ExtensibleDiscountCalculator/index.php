<?php

declare(strict_types=1);

require __DIR__ . '/DiscountStrategyInterface.php';
require __DIR__ . '/NoDiscount.php';
require __DIR__ . '/PercentageDiscount.php';
require __DIR__ . '/FixedAmountDiscount.php';
require __DIR__ . '/WeekendSpecialDiscount.php';
require __DIR__ . '/OrderDiscountCalculator.php';

/*
 * Плохой вариант: класс постоянно меняется, когда появляется новая скидка.
 *
 * final class OrderDiscountCalculator
 * {
 *     public function calculate(float $amount, string $customerType, bool $isWeekend): float
 *     {
 *         $current = $amount;
 *
 *         if ($customerType === 'vip') {
 *             $current -= $amount * 0.1;
 *         }
 *
 *         if ($isWeekend) {
 *             $current -= $amount * 0.05;
 *         }
 *
 *         if ($current > 1000) {
 *             $current -= 50;
 *         }
 *
 *         return round(max($current, 0), 2);
 *     }
 * }
 *
 * Каждый раз, когда появляется новая скидка, нужно модифицировать метод: добавлять ветку
 * или даже менять логику расчёта. Это ломает Open-Closed: класс не открыт для расширения,
 * но открыт для модификации.
 */

$baseAmount = 1_250.00;

$strategies = [
    new PercentageDiscount(10.0),
    new FixedAmountDiscount(40.0),
];

$calculator = new OrderDiscountCalculator($strategies);
$final = $calculator->calculate($baseAmount);

printf("Сумма до скидок: %.2f\n", $baseAmount);
printf("Сумма после стандартных скидок: %.2f\n", $final);

// Добавляем дополнительную стратегию без изменений внутри OrderDiscountCalculator
$extendedStrategies = [
    ...$strategies,
    new WeekendSpecialDiscount(5.0, true), // новая стратегия «особенное уикенд-скидка»
];

$calculatorWithWeekend = new OrderDiscountCalculator($extendedStrategies);
$finalWithWeekend = $calculatorWithWeekend->calculate($baseAmount);

printf("Сумма после всех скидок (включая WeekendSpecial): %.2f\n", $finalWithWeekend);

printf("Принцип OCP: мы не трогаем OrderDiscountCalculator, добавляя новые стратегии.\n");

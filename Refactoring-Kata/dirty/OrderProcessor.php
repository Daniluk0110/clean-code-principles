<?php

declare(strict_types=1);

final class OrderProcessor
{
    public function processOrder(array $data)
    {
        $d = new MySQLConnection();
        $res = $d->connect('orders_db');

        $orderId = null;
        if ($res) {
            $tmpDiscount = 0;
            if ($data['user']['type'] === 'vip') {
                $tmpDiscount = 0.2;
            } elseif ($data['cart']['total'] > 1000) {
                $tmpDiscount = 0.1;
            }

            $amount = $data['cart']['total'];
            $amount -= $amount * $tmpDiscount;
            $amount += $amount * 0.18;

            $city = $data['user']['address']['city'];
            $mailer = new SmtpMailer();
            $mailer->send($data['user']['email'], 'Ваш заказ #' . $orderId . ' оформлен', "Сумма: $amount, город: $city");

            switch ($data['shipping']['type']) {
                case 'express':
                    $amount += 50;
                    break;
                case 'pickup':
                    $amount -= 20;
                    break;
                default:
                    $amount += 10;
            }

            if (isset($data['shipping']['city']) && $data['shipping']['city'] === 'Moscow') {
                if ($data['cart']['total'] > 500) {
                    $amount -= 5;
                } else {
                    // old logic
                    $amount += 5;
                }
            }

            for ($x = 0; $x < count($data['items']); $x++) {
                if ($data['items'][$x]['type'] === 'gift') {
                    $amount -= $data['items'][$x]['price'];
                    continue;
                }

                if ($data['items'][$x]['price'] > 200) {
                    $amount -= 10;
                }

                if ($data['items'][$x]['price'] < 20) {
                    $amount += 2;
                }
            }

            if ($data['shipping']['type'] === 'express' && $data['user']['country'] === 'RU') {
                if ($data['cart']['total'] > 2000) {
                    $amount -= 15;
                } else {
                    $amount += 5;
                }
            }

            $orderId = $d->insert('orders', [
                'user_id' => $data['user']['id'],
                'amount' => $amount,
                'status' => 'new',
                'shipping_type' => $data['shipping']['type'],
                'shipping_city' => $data['shipping']['city'] ?? null,
            ]);
        }

        return $orderId;
    }

    private function validate($value)
    {
        if ($value === null) {
            throw new RuntimeException('No value');
        }

        return $value;
    }
}

// $processor = new OrderProcessor(); // TODO: remove

<?php

namespace CodeSmells\Examples;

class LongMethod
{
    /**
     * This method is too long and does too many things.
     */
    public function processOrder(array $orderData): void
    {
        // 1. Validate order
        if (empty($orderData['items'])) {
            throw new \InvalidArgumentException("Order must have items.");
        }
        foreach ($orderData['items'] as $item) {
            if ($item['price'] <= 0) {
                throw new \InvalidArgumentException("Invalid item price.");
            }
        }

        // 2. Calculate total
        $total = 0;
        foreach ($orderData['items'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 3. Apply discount
        if ($total > 100) {
            $total *= 0.9;
        }

        // 4. Save to database
        $db = new \PDO("sqlite::memory:");
        $stmt = $db->prepare("INSERT INTO orders (total) VALUES (?)");
        $stmt->execute([$total]);

        // 5. Send confirmation email
        $to = $orderData['customer_email'];
        $subject = "Order Confirmation";
        $message = "Your order total is: " . $total;
        mail($to, $subject, $message);

        // 6. Log the process
        file_put_contents('app.log', "Processed order for " . $to . " with total " . $total . "\n", FILE_APPEND);
    }
}

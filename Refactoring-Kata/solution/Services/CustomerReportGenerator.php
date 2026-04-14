<?php

namespace RefactoringKata\Solution\Services;

class CustomerReportGenerator
{
    /**
     * Cleaned version of CustomerReport.
     * SRP: Only handles the orchestration of the report generation.
     */
    public function generate(array $customers): string
    {
        $reportData = $this->calculateReportData($customers);
        return $this->formatAsHtml($reportData);
    }

    private function calculateReportData(array $customers): array
    {
        return array_map(function ($customer) {
            return [
                'name' => $customer['name'],
                'email' => $customer['email'],
                'total_spent' => $this->calculateTotalSpent($customer['orders']),
                'currency' => $customer['currency']
            ];
        }, $customers);
    }

    private function calculateTotalSpent(array $orders): float
    {
        return array_reduce($orders, function ($total, $order) {
            return $total + ($order['status'] === 'completed' ? $order['amount'] : 0);
        }, 0.0);
    }

    private function formatAsHtml(array $data): string
    {
        // Formatting logic separated from calculation.
        // Ideally, this would be in a Template Engine (like Twig).
        ob_start();
        ?>
        <html><body>
        <h1>Customer Report</h1>
        <table>
            <tr><th>Name</th><th>Email</th><th>Total Spent</th></tr>
            <?php foreach ($data as $customer): ?>
                <tr>
                    <td><?= $customer['name'] ?></td>
                    <td><?= $customer['email'] ?></td>
                    <td><?= $customer['total_spent'] ?> <?= $customer['currency'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        </body></html>
        <?php
        return ob_get_clean();
    }
}

<?php

namespace RefactoringKata\Dirty;

class ReportGenerator
{
    /**
     * Mixed logic: data fetching, formatting, and file I/O.
     */
    public function generateReport(string $type, \PDO $db): string
    {
        if ($type === 'sales') {
            $stmt = $db->query("SELECT * FROM sales WHERE date >= date('now', '-30 days')");
            $data = $stmt->fetchAll();
            $report = "--- Monthly Sales Report ---\n";
            $total = 0;
            foreach ($data as $row) {
                $report .= "Order: " . $row['id'] . " | Amount: " . $row['amount'] . "\n";
                $total += $row['amount'];
            }
            $report .= "TOTAL: " . $total . "\n";
        } elseif ($type === 'stock') {
            $stmt = $db->query("SELECT * FROM products WHERE stock_level < 10");
            $data = $stmt->fetchAll();
            $report = "--- Low Stock Alert ---\n";
            foreach ($data as $row) {
                $report .= "Product: " . $row['name'] . " | SKU: " . $row['sku'] . " | Stock: " . $row['stock_level'] . "\n";
            }
        } else {
            throw new \Exception("Invalid report type");
        }

        file_put_contents('last_report.txt', $report);
        return $report;
    }
}

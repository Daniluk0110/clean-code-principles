<?php

namespace RefactoringKata\Solution\Services;

interface ReportStrategy
{
    public function generate(\PDO $db): string;
}

class SalesReportStrategy implements ReportStrategy
{
    public function generate(\PDO $db): string
    {
        $stmt = $db->query("SELECT * FROM sales WHERE date >= date('now', '-30 days')");
        $data = $stmt->fetchAll();
        $report = "--- Monthly Sales Report ---\n";
        $total = 0;
        foreach ($data as $row) {
            $report .= "Order: " . $row['id'] . " | Amount: " . $row['amount'] . "\n";
            $total += $row['amount'];
        }
        $report .= "TOTAL: " . $total . "\n";
        return $report;
    }
}

class StockReportStrategy implements ReportStrategy
{
    public function generate(\PDO $db): string
    {
        $stmt = $db->query("SELECT * FROM products WHERE stock_level < 10");
        $data = $stmt->fetchAll();
        $report = "--- Low Stock Alert ---\n";
        foreach ($data as $row) {
            $report .= "Product: " . $row['name'] . " | SKU: " . $row['sku'] . " | Stock: " . $row['stock_level'] . "\n";
        }
        return $report;
    }
}

class ReportExporter
{
    private \PDO $db;
    private array $strategies = [];

    public function __construct(\PDO $db)
    {
        $this->db = $db;
        $this->strategies['sales'] = new SalesReportStrategy();
        $this->strategies['stock'] = new StockReportStrategy();
    }

    /**
     * Cleaned version of ReportGenerator using Strategy pattern.
     */
    public function export(string $type): string
    {
        if (!isset($this->strategies[$type])) {
            throw new \Exception("Invalid report type");
        }

        $report = $this->strategies[$type]->generate($this->db);
        file_put_contents('last_report.txt', $report);
        return $report;
    }
}

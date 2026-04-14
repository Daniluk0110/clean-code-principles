<?php

namespace RefactoringKata\Dirty;

class InvoiceService
{
    /**
     * Big messy method with mixed responsibilities.
     */
    public function processInvoice(int $id, array $data): void
    {
        $db = new \PDO("sqlite::memory:");
        $stmt = $db->prepare("SELECT * FROM invoices WHERE id = ?");
        $stmt->execute([$id]);
        $invoice = $stmt->fetch();

        if (!$invoice) {
            throw new \Exception("Invoice not found");
        }

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['qty'] * $item['price'];
        }

        if ($data['tax_exempt'] === false) {
            $total *= 1.2; // 20% tax
        }

        $stmt = $db->prepare("UPDATE invoices SET total = ?, status = 'processed' WHERE id = ?");
        $stmt->execute([$total, $id]);

        $msg = "Invoice $id processed. Total: $total";
        mail($data['email'], "Invoice Processed", $msg);

        echo "Log: " . $msg . "\n";
    }
}

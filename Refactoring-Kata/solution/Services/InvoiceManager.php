<?php

namespace RefactoringKata\Solution\Services;

class InvoiceManager
{
    private \PDO $db;
    private $notifier;
    private $taxCalculator;

    public function __construct(\PDO $db, $notifier, $taxCalculator)
    {
        $this->db = $db;
        $this->notifier = $notifier;
        $this->taxCalculator = $taxCalculator;
    }

    /**
     * Cleaned version of InvoiceService.
     * Dependencies are injected, and logic is delegated.
     */
    public function processInvoice(int $id, array $data): void
    {
        $invoice = $this->findInvoice($id);
        
        $subTotal = $this->calculateSubTotal($data['items']);
        $total = $this->taxCalculator->calculate($subTotal, $data['tax_exempt']);

        $this->updateInvoice($id, $total);
        $this->notifier->sendProcessingConfirmation($data['email'], $id, $total);
    }

    private function findInvoice(int $id): array
    {
        $stmt = $this->db->prepare("SELECT * FROM invoices WHERE id = ?");
        $stmt->execute([$id]);
        $invoice = $stmt->fetch();

        if (!$invoice) {
            throw new \Exception("Invoice not found");
        }
        return $invoice;
    }

    private function calculateSubTotal(array $items): float
    {
        return array_reduce($items, function ($sum, $item) {
            return $sum + ($item['qty'] * $item['price']);
        }, 0.0);
    }

    private function updateInvoice(int $id, float $total): void
    {
        $stmt = $this->db->prepare("UPDATE invoices SET total = ?, status = 'processed' WHERE id = ?");
        $stmt->execute([$total, $id]);
    }
}

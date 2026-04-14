<?php

namespace CodeSmells\Examples;

class LargeClass
{
    private array $items = [];
    private float $totalPrice = 0;
    private string $customerName;
    private string $customerEmail;
    private string $shippingAddress;
    private string $billingAddress;
    private float $discount = 0;
    private array $appliedCoupons = [];
    private string $paymentMethod;
    private bool $isPaid = false;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;
    private string $status;
    private float $taxAmount = 0;
    private string $currency = 'USD';
    private string $orderNotes = '';
    private string $trackingNumber = '';

    public function __construct(string $customerName, string $customerEmail)
    {
        $this->customerName = $customerName;
        $this->customerEmail = $customerEmail;
        $this->createdAt = new \DateTime();
        $this->status = 'pending';
    }

    public function addItem(array $item): void
    {
        $this->items[] = $item;
        $this->calculateTotal();
    }

    private function calculateTotal(): void
    {
        $this->totalPrice = 0;
        foreach ($this->items as $item) {
            $this->totalPrice += $item['price'] * $item['quantity'];
        }
        $this->applyDiscount();
        $this->calculateTax();
    }

    private function applyDiscount(): void
    {
        if ($this->totalPrice > 500) {
            $this->discount = $this->totalPrice * 0.15;
            $this->totalPrice -= $this->discount;
        }
    }

    private function calculateTax(): void
    {
        $this->taxAmount = $this->totalPrice * 0.08;
        $this->totalPrice += $this->taxAmount;
    }

    public function setShippingAddress(string $address): void { $this->shippingAddress = $address; }
    public function setBillingAddress(string $address): void { $this->billingAddress = $address; }
    public function applyCoupon(string $couponCode): void { $this->appliedCoupons[] = $couponCode; $this->calculateTotal(); }
    public function setPaymentMethod(string $method): void { $this->paymentMethod = $method; }
    public function markAsPaid(): void { $this->isPaid = true; $this->status = 'paid'; }
    public function setStatus(string $status): void { $this->status = $status; }
    public function addNote(string $note): void { $this->orderNotes .= $note . "\n"; }
    public function setTrackingNumber(string $trackingNumber): void { $this->trackingNumber = $trackingNumber; }

    public function generateInvoice(): string
    {
        return "Invoice for " . $this->customerName . " with total " . $this->totalPrice;
    }

    public function sendConfirmationEmail(): void
    {
        mail($this->customerEmail, "Order Confirmed", "Total: " . $this->totalPrice);
    }

    public function saveToDatabase(): void
    {
        // ... (Database logic)
    }

    public function exportToCsv(): string
    {
        // ... (CSV export logic)
    }

    public function validateShippingAddress(): bool
    {
        // ... (Validation logic)
        return !empty($this->shippingAddress);
    }

    public function calculateShippingCost(): float
    {
        // ... (Shipping calculation logic)
        return 10.0;
    }
}

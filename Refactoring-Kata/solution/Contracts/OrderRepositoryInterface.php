<?php

declare(strict_types=1);

namespace RefactoringKata\Contracts;

use RefactoringKata\Services\Order;

interface OrderRepositoryInterface
{
    public function save(Order $order): void;
}

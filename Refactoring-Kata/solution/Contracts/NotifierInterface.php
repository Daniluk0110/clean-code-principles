<?php

declare(strict_types=1);

namespace RefactoringKata\Contracts;

use RefactoringKata\Services\Order;

interface NotifierInterface
{
    public function send(Order $order): void;
}

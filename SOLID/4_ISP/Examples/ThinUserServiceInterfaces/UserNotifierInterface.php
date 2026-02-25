<?php

declare(strict_types=1);

interface UserNotifierInterface
{
    public function sendWelcome(string $email): void;
}

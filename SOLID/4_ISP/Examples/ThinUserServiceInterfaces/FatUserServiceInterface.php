<?php

declare(strict_types=1);

interface FatUserServiceInterface
{
    public function register(string $email, string $password): string;

    public function sendWelcome(string $email): void;

    public function updateProfile(string $userId, array $profileData): void;

    public function generateAdminReport(string $from, string $to): string;

    public function saveToDb(string $userId, array $payload): void;
}

<?php

declare(strict_types=1);

interface UserProfileUpdaterInterface
{
    public function updateProfile(string $userId, array $profileData): void;
}

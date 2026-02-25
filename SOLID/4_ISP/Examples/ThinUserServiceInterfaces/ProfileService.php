<?php

declare(strict_types=1);

final class ProfileService implements UserProfileUpdaterInterface
{
    public function updateProfile(string $userId, array $profileData): void
    {
        file_put_contents('php://stdout', sprintf("Профиль %s обновлён: %s\n", $userId, json_encode($profileData)), FILE_APPEND);
    }
}

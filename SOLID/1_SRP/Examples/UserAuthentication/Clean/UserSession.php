<?php

namespace SOLID\SRP\Examples\UserAuthentication\Clean;

class UserSession
{
    /**
     * Follows SRP: only handles user session state.
     */
    public function startForUser(int $userId): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user_id'] = $userId;
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function getCurrentUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }
}

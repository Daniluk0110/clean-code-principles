<?php

namespace SOLID\SRP\Examples\UserAuthentication\Dirty;

class AuthService
{
    /**
     * Violates SRP: handles authentication, session, and password hashing.
     */
    public function login(string $username, string $password): bool
    {
        // 1. Fetch user from DB
        $db = new \PDO("sqlite::memory:");
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        // 2. Verify password (hashing logic inside)
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // 3. Start session
        session_start();
        $_SESSION['user_id'] = $user['id'];

        // 4. Log login
        file_put_contents('auth.log', "User $username logged in at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

        return true;
    }
}

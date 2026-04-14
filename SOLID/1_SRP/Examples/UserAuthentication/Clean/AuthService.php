<?php

namespace SOLID\SRP\Examples\UserAuthentication\Clean;

class AuthService
{
    private $userRepository;
    private $passwordHasher;
    private $session;
    private $logger;

    public function __construct($userRepository, $passwordHasher, $session, $logger)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->session = $session;
        $this->logger = $logger;
    }

    /**
     * Follows SRP: orchestrates authentication process.
     */
    public function login(string $username, string $password): bool
    {
        $user = $this->userRepository->findByUsername($username);

        if (!$user || !$this->passwordHasher->verify($password, $user->getPasswordHash())) {
            return false;
        }

        $this->session->startForUser($user->getId());
        $this->logger->info("User $username logged in");

        return true;
    }
}

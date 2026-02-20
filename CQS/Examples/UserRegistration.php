<?php

declare(strict_types=1);

final class User
{
    public function __construct(
        public string $id,
        public string $email,
        public string $name
    ) {}
}

final class UserRepository
{
    /**
     * Команда: создаёт пользователя и сохраняет.
     */
    public function create(string $email, string $name): User
    {
        $user = new User(uniqid(), $email, $name);
        // persist to storage
        return $user;
    }

    /**
     * Запрос: возвращает пользователя.
     */
    public function findByEmail(string $email): ?User
    {
        return null; // example stub
    }
}

final class EmailService
{
    public function sendWelcome(User $user): void
    {
        echo "Email sent to {$user->email}" . PHP_EOL;
    }
}

final class UserRegistrationService
{
    private UserRepository $repository;
    private EmailService $emailService;

    public function __construct(UserRepository $repository, EmailService $emailService)
    {
        $this->repository = $repository;
        $this->emailService = $emailService;
    }

    /**
     * ❌ Метод смешивает команды и запросы: создаёт, возвращает сущность и отправляет email.
     */
    public function register(string $email, string $name): User
    {
        $user = $this->repository->create($email, $name);
        $this->emailService->sendWelcome($user);
        return $user;
    }
}

// ✅ Правильная CQS-версия
final class RegisterUserCommand
{
    public function __construct(public string $email, public string $name) {}
}

final class RegisterUserHandler
{
    public function __construct(private UserRepository $repository, private EmailService $emailService) {}

    public function handle(RegisterUserCommand $command): void
    {
        $user = $this->repository->create($command->email, $command->name);
        $this->emailService->sendWelcome($user);
    }
}

// Отдельные запросы:
// $repository->findById();
// $repository->findByEmail();

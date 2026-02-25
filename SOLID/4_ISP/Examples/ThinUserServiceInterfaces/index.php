<?php

declare(strict_types=1);

require __DIR__ . '/FatUserServiceInterface.php';
require __DIR__ . '/UserRegistratorInterface.php';
require __DIR__ . '/UserNotifierInterface.php';
require __DIR__ . '/UserProfileUpdaterInterface.php';
require __DIR__ . '/UserReportGeneratorInterface.php';
require __DIR__ . '/RegistrationService.php';
require __DIR__ . '/NotificationService.php';
require __DIR__ . '/ProfileService.php';
require __DIR__ . '/AdminReportService.php';

/*
 * Плохой подход: один интерфейс, который таскает все методы — регистрация, уведомление, профиль,
 * отчёты и сохранение. Любой сервис, даже если он делает только регистрацию, вынужден реализовывать
 * всё подряд. Это нарушает ISP: клиент вынужден знать методы, которые ему не нужны.
 */

final class LegacyUserService implements FatUserServiceInterface
{
    public function register(string $email, string $password): string
    {
        return hash('sha256', $email . $password);
    }

    public function sendWelcome(string $email): void
    {
        file_put_contents('php://stdout', "Welcome: {$email}\n", FILE_APPEND);
    }

    public function updateProfile(string $userId, array $profileData): void
    {
        file_put_contents('php://stdout', sprintf("Legacy profile %s updated\n", $userId), FILE_APPEND);
    }

    public function generateAdminReport(string $from, string $to): string
    {
        return "report";
    }

    public function saveToDb(string $userId, array $payload): void
    {
        // Тот же метод, которому нужно подключить Модель и репозиторий.
        file_put_contents('php://stdout', "Saving {$userId}\n", FILE_APPEND);
    }
}

$email = 'dev@company.local';

/*
 * Новый подход: фасеты с точечной ответственностью. Каждому сервису — свой контракт.
 */

$registrator = new RegistrationService();
$userId = $registrator->register($email, 'VeryStrongPassword');

$notifier = new NotificationService();
$notifier->sendWelcome($email);

$profileService = new ProfileService();
$profileService->updateProfile($userId, ['city' => 'Moscow']);

$reportService = new AdminReportService();
$report = $reportService->generateAdminReport('2026-01-01', '2026-02-01');

printf("Legacy FatUserService давал всё сразу, но клиенту нужно было гораздо меньше.\n");
printf("Теперь: регистрация -> уведомление -> профиль -> отчёт (каждый сервис реализует только нужный метод).\n");
printf("Отчёт: %s\n", $report);

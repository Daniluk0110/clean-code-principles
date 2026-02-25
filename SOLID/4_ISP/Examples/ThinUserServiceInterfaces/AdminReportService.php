<?php

declare(strict_types=1);

final class AdminReportService implements UserReportGeneratorInterface
{
    public function generateAdminReport(string $from, string $to): string
    {
        return sprintf('Report for %s - %s: %d активных пользователей', $from, $to, random_int(100, 500));
    }
}

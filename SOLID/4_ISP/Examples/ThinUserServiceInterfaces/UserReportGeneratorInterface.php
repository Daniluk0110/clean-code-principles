<?php

declare(strict_types=1);

interface UserReportGeneratorInterface
{
    public function generateAdminReport(string $from, string $to): string;
}

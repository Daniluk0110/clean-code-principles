<?php

declare(strict_types=1);

final class ReportExporter
{
    /**
     * @param array<int, array> $data
     */
    public function export(array $data): void
    {
        $csv = "id,name,status\n";

        // Уровень 1
        foreach ($data as $row) {
            // Уровень 2
            if (isset($row['status'])) {
                // Уровень 3
                if ($row['status'] === 'active') {
                    $csv .= "{$row['id']},{$row['name']},{$row['status']}\n";
                }
            }
        }

        echo "Экспортировано:\n" . $csv;
    }
}

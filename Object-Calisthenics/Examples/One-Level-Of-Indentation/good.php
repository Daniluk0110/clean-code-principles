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

        // Уровень 1 (только один!)
        foreach ($data as $row) {
            $csv .= $this->formatActiveRow($row);
        }

        echo "Экспортировано:\n" . $csv;
    }

    private function formatActiveRow(array $row): string
    {
        if ($this->isActiveRow($row)) {
            return "{$row['id']},{$row['name']},{$row['status']}\n";
        }

        return '';
    }

    private function isActiveRow(array $row): bool
    {
        return isset($row['status']) && $row['status'] === 'active';
    }
}

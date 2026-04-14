<?php

namespace SOLID\OCP\Examples\ReportExporting\Clean;

class CsvExporter implements ExportStrategy
{
    public function export(array $data): string
    {
        $output = fopen('php://temp', 'r+');
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        return $csv;
    }
}

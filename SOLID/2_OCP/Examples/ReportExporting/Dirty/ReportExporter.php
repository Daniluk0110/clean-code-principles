<?php

namespace SOLID\OCP\Examples\ReportExporting\Dirty;

class ReportExporter
{
    /**
     * Violates OCP: if we want to add XML, we must MODIFY this class.
     */
    public function export(array $data, string $format): string
    {
        if ($format === 'json') {
            return json_encode($data);
        } elseif ($format === 'csv') {
            $output = fopen('php://temp', 'r+');
            foreach ($data as $row) {
                fputcsv($output, $row);
            }
            rewind($output);
            $csv = stream_get_contents($output);
            fclose($output);
            return $csv;
        }

        throw new \InvalidArgumentException("Unsupported format: " . $format);
    }
}

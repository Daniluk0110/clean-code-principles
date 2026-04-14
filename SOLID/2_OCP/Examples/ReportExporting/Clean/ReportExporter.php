<?php

namespace SOLID\OCP\Examples\ReportExporting\Clean;

class ReportExporter
{
    /**
     * Follows OCP: open for extension (add new strategies) 
     * but closed for modification.
     */
    public function export(array $data, ExportStrategy $strategy): string
    {
        return $strategy->export($data);
    }
}

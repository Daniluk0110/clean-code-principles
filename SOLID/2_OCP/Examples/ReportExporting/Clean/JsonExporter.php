<?php

namespace SOLID\OCP\Examples\ReportExporting\Clean;

class JsonExporter implements ExportStrategy
{
    public function export(array $data): string
    {
        return json_encode($data);
    }
}

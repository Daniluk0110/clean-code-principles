<?php

namespace SOLID\OCP\Examples\ReportExporting\Clean;

interface ExportStrategy
{
    public function export(array $data): string;
}

<?php

namespace SOLID\OCP\Examples\ReportExporting\Clean;

class XmlExporter implements ExportStrategy
{
    public function export(array $data): string
    {
        $xml = new \SimpleXMLElement('<report/>');
        foreach ($data as $row) {
            $item = $xml->addChild('item');
            foreach ($row as $key => $value) {
                $item->addChild($key, (string)$value);
            }
        }
        return $xml->asXML();
    }
}

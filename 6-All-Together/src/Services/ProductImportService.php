<?php

declare(strict_types=1);

require_once __DIR__ . '/../Contracts/ProductParser.php';
require_once __DIR__ . '/../Contracts/ProductValidator.php';
require_once __DIR__ . '/../Contracts/ProductRepository.php';
require_once __DIR__ . '/../Contracts/Notifier.php';
require_once __DIR__ . '/../DTO/ImportReport.php';

final class ProductImportService
{
    public function __construct(
        private ProductParser $parser,
        private ProductValidator $validator,
        private ProductRepository $repository,
        private Notifier $notifier,
    ) {}

    public function import(string $raw): ImportReport
    {
        $report = new ImportReport();

        foreach ($this->parser->parse($raw) as $product) {
            $errors = $this->validator->validate($product);

            if ($errors !== []) {
                $report->skipped++;
                $report->addError($product->sku, $errors);
                continue;
            }

            $this->repository->save($product);
            $report->imported++;
        }

        $this->notifier->notify(
            "Imported {$report->imported}, skipped {$report->skipped}"
        );

        return $report;
    }
}

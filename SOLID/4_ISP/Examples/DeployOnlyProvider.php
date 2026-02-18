<?php

declare(strict_types=1);

require_once __DIR__ . '/AppDeployer.php';

final class DeployOnlyProvider implements AppDeployer
{
    public function deployApp(string $app, string $version): void
    {
        echo "Deploy {$app}:{$version}" . PHP_EOL;
    }
}

<?php

declare(strict_types=1);

require_once __DIR__ . '/DeployOnlyProvider.php';

function deployRelease(AppDeployer $deployer, string $app, string $version): void
{
    $deployer->deployApp($app, $version);
}

$provider = new DeployOnlyProvider();

deployRelease($provider, 'billing', '1.4.2');

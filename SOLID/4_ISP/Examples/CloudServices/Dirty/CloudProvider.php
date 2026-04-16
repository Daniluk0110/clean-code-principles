<?php

declare(strict_types=1);

interface CloudProviderInterface
{
    public function deployApp(string $app, string $version): void;
    public function manageDatabase(string $dbName): void;
    public function setupCDN(string $domain): void;
}

final class DeployOnlyProvider implements CloudProviderInterface
{
    public function deployApp(string $app, string $version): void
    {
        echo "Deploy {$app}:{$version}" . PHP_EOL;
    }

    public function manageDatabase(string $dbName): void
    {
        throw new RuntimeException('Database is not supported');
    }

    public function setupCDN(string $domain): void
    {
        throw new RuntimeException('CDN is not supported');
    }
}

$provider = new DeployOnlyProvider();
$provider->deployApp('my_app', 'v1.0');
// $provider->setupCDN('example.com'); // FATAL ERROR

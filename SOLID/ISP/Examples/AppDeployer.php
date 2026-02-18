<?php

declare(strict_types=1);

interface AppDeployer
{
    public function deployApp(string $app, string $version): void;
}

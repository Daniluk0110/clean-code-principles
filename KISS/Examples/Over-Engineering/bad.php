<?php

declare(strict_types=1);

// ❌ Слишком много абстракций для простейшей задачи

interface ConfigurationProviderInterface
{
    public function getValue(string $key): mixed;
}

abstract class AbstractConfigurationProvider implements ConfigurationProviderInterface
{
    protected array $settings = [];

    public function getValue(string $key): mixed
    {
        return $this->settings[$key] ?? null;
    }
}

final class ArrayConfigurationProvider extends AbstractConfigurationProvider
{
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }
}

final class ConfigurationFactory
{
    public static function createFromArray(array $settings): ConfigurationProviderInterface
    {
        return new ArrayConfigurationProvider($settings);
    }
}

// Использование:
$config = ConfigurationFactory::createFromArray(['timezone' => 'UTC', 'debug' => true]);
$timezone = $config->getValue('timezone');

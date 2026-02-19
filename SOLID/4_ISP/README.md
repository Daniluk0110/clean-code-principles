# ISP — Interface Segregation Principle 🧩

**Расшифровка (EN):** Interface Segregation Principle.  
**Расшифровка (RU):** Принцип разделения интерфейсов.

**Суть:** клиент не должен зависеть от методов, которые он не использует. Лучше несколько маленьких интерфейсов, чем один «толстый». ✅

**Почему важно:** маленькие интерфейсы уменьшают связанность, упрощают реализацию и делают систему гибкой. 💡

## Теория простыми словами 📌
- Интерфейс описывает контракт конкретного клиента.
- Лишние методы — это лишняя зависимость.
- Разделяй интерфейсы по ролям и сценариям.

## Как понять, что интерфейс слишком большой 🧭
- Реализации вынуждены делать пустые методы.
- Методам ставят `throw new NotImplementedException`.
- Любое расширение ломает сразу много классов.

## Запахи кода 👃
- «Толстые» интерфейсы с десятками методов.
- Классы реализуют методы, которые им не нужны.
- Любое расширение интерфейса ломает много реализаций.
- Клиенты вынуждены знать лишние детали.

## Было (Плохо) ❌
```php
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
```

## Стало (Хорошо) ✅
```php
<?php

declare(strict_types=1);

interface AppDeployer
{
    public function deployApp(string $app, string $version): void;
}

interface DatabaseManager
{
    public function manageDatabase(string $dbName): void;
}

interface CdnManager
{
    public function setupCDN(string $domain): void;
}

final class DeployOnlyProvider implements AppDeployer
{
    public function deployApp(string $app, string $version): void
    {
        echo "Deploy {$app}:{$version}" . PHP_EOL;
    }
}
```

## Пример мини‑системы (Examples/) 🧪
В папке `Examples/` лежат 5 файлов с полностью рабочим примером без фреймворков:
- `AppDeployer.php`
- `DatabaseManager.php`
- `CdnManager.php`
- `DeployOnlyProvider.php`
- `index.php`

Запуск:
```bash
php index.php
```

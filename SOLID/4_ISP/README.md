# ISP — Interface Segregation Principle 🧩

**Расшифровка (EN):** Interface Segregation Principle.  
**Расшифровка (RU):** Принцип разделения интерфейсов.

**Суть:** клиент не должен зависеть от методов, которые он не использует. Лучше несколько маленьких интерфейсов, чем один «толстый». ✅

**Почему важно:** маленькие интерфейсы уменьшают связанность, упрощают реализацию и делают систему гибкой. 💡

### 💸 Бизнес-риски
- **Сложность разработки:** Когда в компанию приходит новый вендор (например, отправка SMS), разработчику приходится реализовывать гигантский интерфейс `NotificationServiceProvider`, в котором 90% методов — это заглушки.
- **Внезапные поломки из-за интерфейсов-монстров:** При добавлении метода `manageKubernetesCluster` в общий интерфейс `CloudProviderInterface`, ломаются абсолютно все классы-провайдеры, даже те, которые отвечают только за простую отправку файлов на FTP. 

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
В папке `Examples/CloudServices/` лежат две версии кода:
- `Dirty/CloudProvider.php` (Толстый интерфейс с NotSupportedExceptions)
- `Clean/` (Маленькие узконаправленные интерфейсы)

### 🧪 Как это тестировать?
Мокировать огромный интерфейс в PHPUnit — это долго и муторно (приходится заглушать десятки методов, которые даже не нужны для теста).
С разделенными интерфейсами вы мокаете только то, что реально нужно вашему сервису.

```php
public function testDeploymentServiceCallsDeployer(): void
{
    // Мокаем только AppDeployer! Нам не нужно мокать БД или CDN.
    $deployerMock = $this->createMock(AppDeployer::class);
    $deployerMock->expects($this->once())
                 ->method('deployApp')
                 ->with('my_app', 'v1.0');

    $service = new DeploymentService($deployerMock);
    $service->runDeployment('my_app', 'v1.0');
}
```

Запуск:
```bash
php SOLID/4_ISP/Examples/CloudServices/Dirty/CloudProvider.php
php SOLID/4_ISP/Examples/CloudServices/Clean/index.php
```

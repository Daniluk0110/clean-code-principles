# YAGNI 🚫

Раздел о принципе YAGNI (You Aren't Gonna Need It) — не писать код "про запас". Если фичи нет в текущем ТЗ, преждевременные абстракции тратят время и усложняют поддержку. Гораздо дешевле добавить расширение, когда оно действительно нужно.

## Почему "про запас" — плохо ⚠️
- Лишние абстракции увеличивают когнитивную нагрузку и усложняют отладку.
- Избыточный код требует тестов и поддержки, хотя не приносит ценности.
- Реальные требования часто отличаются от предположений, и заранее сделанная архитектура мешает адаптации.

## Когда абстракции оправданы ✅
- Есть подтвержденный сценарий на ближайшие задачи.
- Уже есть вторая реализация или конкретные требования к ней.
- Стоимость изменения сейчас выше, чем добавление слоя.

## Запахи кода 👃
- Интерфейсы с одной реализацией "на будущее".
- Избыточные параметры функций, которые никогда не используются.

## Было (Плохо) ❌

Задача: сохранять аватарки пользователей. Но разработчик заранее делает инфраструктуру для S3, хотя ключей AWS нет и нужен только локальный диск.

```php
<?php

declare(strict_types=1);

interface StorageInterface
{
    public function put(string $path, string $contents): void;
}

final class LocalStorage implements StorageInterface
{
    public function __construct(private string $basePath)
    {
    }

    public function put(string $path, string $contents): void
    {
        $fullPath = rtrim($this->basePath, '/').'/'.ltrim($path, '/');
        $dir = dirname($fullPath);

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        file_put_contents($fullPath, $contents);
    }
}

final class S3Storage implements StorageInterface
{
    public function __construct(
        private string $bucket,
        private string $accessKey,
        private string $secretKey,
    ) {
    }

    public function put(string $path, string $contents): void
    {
        throw new RuntimeException('S3 не настроен');
    }
}

final class AvatarUploader
{
    public function __construct(private StorageInterface $storage)
    {
    }

    public function upload(int $userId, string $contents, string $extension): string
    {
        $path = "avatars/{$userId}.{$extension}";
        $this->storage->put($path, $contents);

        return $path;
    }
}
```

## Стало (Хорошо) ✅

Нужен только локальный диск — значит делаем простой загрузчик без лишней инфраструктуры.

```php
<?php

declare(strict_types=1);

final class AvatarUploader
{
    public function __construct(private string $basePath)
    {
    }

    public function upload(int $userId, string $contents, string $extension): string
    {
        $path = "avatars/{$userId}.{$extension}";
        $fullPath = rtrim($this->basePath, '/').'/'.ltrim($path, '/');
        $dir = dirname($fullPath);

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        file_put_contents($fullPath, $contents);

        return $path;
    }
}
```

## Примеры запуска ▶️

```bash
php YAGNI/Examples/bad.php
php YAGNI/Examples/good.php
```

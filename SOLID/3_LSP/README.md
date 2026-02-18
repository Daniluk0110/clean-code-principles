# LSP — Liskov Substitution Principle 🔁

**Расшифровка (EN):** Liskov Substitution Principle.
**Расшифровка (RU):** Принцип подстановки Лисков.

**Суть (очень простыми словами):** если код работает с базовым типом, то он должен **так же корректно** работать с любым его подтипом. Подкласс не должен ломать ожидания, которые задал базовый контракт. ✅

**Почему важно:** если подтип меняет поведение, всё «снаружи» начинает вести себя непредсказуемо. Это источник скрытых багов и сложной поддержки. 💡

## Запахи кода 👃
- Подкласс выбрасывает `NotImplementedException` там, где базовый класс обещал работу.
- Подкласс меняет тип возвращаемого значения или смысл результата.
- Подкласс усиливает предусловия (требует то, чего базовый класс не требовал).
- Подкласс ослабляет постусловия (гарантирует меньше, чем базовый класс).

## Было (Плохо) ❌
```php
<?php

declare(strict_types=1);

abstract class FileStorage
{
    /**
     * Договор: запись должна работать.
     */
    abstract public function write(string $path, string $contents): void;

    abstract public function read(string $path): string;
}

final class ReadOnlyStorage extends FileStorage
{
    public function write(string $path, string $contents): void
    {
        // Ломает контракт базового класса: запись должна работать
        throw new RuntimeException('Read-only storage');
    }

    public function read(string $path): string
    {
        return 'data';
    }
}
```

## Стало (Хорошо) ✅
```php
<?php

declare(strict_types=1);

interface ReadableStorage
{
    public function read(string $path): string;
}

interface WritableStorage
{
    public function write(string $path, string $contents): void;
}

final class InMemoryStorage implements ReadableStorage, WritableStorage
{
    private array $data = [];

    public function read(string $path): string
    {
        return $this->data[$path] ?? '';
    }

    public function write(string $path, string $contents): void
    {
        $this->data[$path] = $contents;
    }
}

final class ReadOnlyStorage implements ReadableStorage
{
    public function __construct(private ReadableStorage $storage) {}

    public function read(string $path): string
    {
        return $this->storage->read($path);
    }
}
```

## Пример мини‑системы (Examples/) 🧪
В папке `Examples/` лежат 5 файлов с полностью рабочим примером без фреймворков:
- `ReadableStorage.php`
- `WritableStorage.php`
- `InMemoryStorage.php`
- `ReadOnlyStorage.php`
- `index.php`

Запуск:
```bash
php index.php
```

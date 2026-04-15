# LSP — Liskov Substitution Principle 🔁

**Расшифровка (EN):** Liskov Substitution Principle.  
**Расшифровка (RU):** Принцип подстановки Лисков.

**Суть:** если код работает с базовым типом, то он должен **так же корректно** работать с любым его подтипом. Подкласс не должен ломать ожидания, которые задал базовый контракт. ✅

**Почему важно:** если подтип меняет поведение, всё «снаружи» начинает вести себя непредсказуемо. Это источник скрытых багов и сложной поддержки. 💡

### 💸 Бизнес-риски
- **Скрытые падения в рантайме:** Если класс `ReadOnlyStorage` наследуется от `FileStorage`, но выбрасывает исключение при попытке записи, система упадет ровно в тот момент, когда фоновый воркер попытается сохранить резервную копию.
- **Множество костылей (Type checking):** Разработчикам придется писать проверки типа `if (!$storage instanceof ReadOnlyStorage)` по всему проекту, нарушая OCP и создавая запутанный код-спагетти.

## Теория простыми словами 📌
- Подтип должен соблюдать контракт базового типа.
- Нельзя усиливать предусловия и ослаблять постусловия.
- Если базовый класс обещает поведение, подтип должен его сохранять.

## Как проверить себя 🧭
- Можно ли подставить подтип в существующий код без `try/catch` и `if`?
- Не меняется ли смысл результата?
- Не появляются ли новые исключения там, где их раньше не было?

## Запахи кода 👃
- Подкласс выбрасывает `NotImplementedException` там, где базовый класс обещал работу.
- Подкласс меняет тип возвращаемого значения или смысл результата.
- Подкласс усиливает предусловия.
- Подкласс ослабляет постусловия.

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
В папке `Examples/Storage/` лежат две версии кода:
- `Dirty/FileStorage.php` (Нарушение LSP, класс падает при вызове метода родителя)
- `Clean/` (Разделение интерфейсов на чтение и запись)

### 🧪 Как это тестировать?
Соблюдение LSP гарантирует, что ваши моки в тестах будут правдивыми. Если вы создаете мок для базового класса, он должен вести себя так же, как любой его подкласс.
В правильном подходе (Clean) мы можем написать контрактный тест (Interface Test), который будут проходить все реализации `WritableStorage`.

```php
public function testStorageWritesData(): void
{
    $storage = new InMemoryStorage();
    $storage->write('/test.txt', 'hello');

    $this->assertEquals('hello', $storage->read('/test.txt'));
}
```

Запуск:
```bash
php SOLID/3_LSP/Examples/Storage/Dirty/FileStorage.php
php SOLID/3_LSP/Examples/Storage/Clean/index.php
```

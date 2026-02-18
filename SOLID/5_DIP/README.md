# DIP — Dependency Inversion Principle 🔌

**Расшифровка (EN):** Dependency Inversion Principle.
**Расшифровка (RU):** Принцип инверсии зависимостей.

**Суть:**
- Высокоуровневые модули (бизнес‑логика) **не должны зависеть** от низкоуровневых (деталей хранения, транспорта, фреймворка).
- Оба уровня должны зависеть от **абстракций**, а не от конкретных реализаций. ✅

**Почему важно:** мы можем менять детали (например, MySQL на PostgreSQL) без переписывания бизнес‑логики. 💡

## Запахи кода 👃
- В бизнес‑логике часто встречается `new` конкретных классов (например, `new MySQLDatabase()`).
- Класс «знает» слишком много о том, как устроены его зависимости.
- Тестирование требует настоящей базы/сети, потому что зависимость нельзя заменить.

## Было (Плохо) ❌
```php
<?php

declare(strict_types=1);

final class MySQLDatabase
{
    public function fetchUserById(int $id): array
    {
        return ['id' => $id, 'name' => 'Jane'];
    }
}

final class UserService
{
    private MySQLDatabase $db;

    public function __construct()
    {
        // Жесткая зависимость от конкретной реализации
        $this->db = new MySQLDatabase();
    }

    public function getUser(int $id): array
    {
        return $this->db->fetchUserById($id);
    }
}
```

## Стало (Хорошо) ✅
```php
<?php

declare(strict_types=1);

interface DatabaseInterface
{
    public function fetchUserById(int $id): array;
}

final class MySQLDatabase implements DatabaseInterface
{
    public function fetchUserById(int $id): array
    {
        return ['id' => $id, 'name' => 'Jane'];
    }
}

final class UserService
{
    public function __construct(private DatabaseInterface $db) {}

    public function getUser(int $id): array
    {
        return $this->db->fetchUserById($id);
    }
}
```

## Пример мини‑системы (Examples/) 🧪
В папке `Examples/` лежат 5 файлов с полностью рабочим примером без фреймворков:
- `DatabaseInterface.php`
- `MySQLDatabase.php`
- `UserService.php`
- `Container.php`
- `index.php`

Запуск:
```bash
php index.php
```

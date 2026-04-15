# DIP — Dependency Inversion Principle 🔌

**Расшифровка (EN):** Dependency Inversion Principle.  
**Расшифровка (RU):** Принцип инверсии зависимостей.

**Суть:**
- Высокоуровневые модули (бизнес‑логика) **не должны зависеть** от низкоуровневых (деталей хранения, транспорта, фреймворка).
- Оба уровня должны зависеть от **абстракций**, а не от конкретных реализаций. ✅

**Почему важно:** мы можем менять детали (например, MySQL на PostgreSQL) без переписывания бизнес‑логики. 💡

### 💸 Бизнес-риски
- **Невозможность юнит-тестирования:** Если `UserService` сам делает `new MySQLDatabase()`, вы не сможете протестировать сервис без поднятия реальной базы данных. Тесты будут медленными (минуты вместо миллисекунд), хрупкими (упали из-за сети) и дорогими в поддержке.
- **Вендор-лок (Vendor Lock-in):** Ваш код навсегда привязан к одному инструменту. Если завтра бизнес решит переехать на облачную базу данных, вам придется переписывать сотни классов бизнес-логики, которые напрямую зависели от MySQL.

## Теория простыми словами 📌
- Бизнес-логика не должна знать, где и как хранятся данные.
- Конкретные реализации подставляются снаружи.
- Зависимость направлена в сторону контракта, а не реализации.

## Как проверить себя 🧭
- Есть ли `new` конкретных классов внутри бизнес-сервиса?
- Можно ли заменить хранилище без правок сервиса?
- Можно ли протестировать сервис без настоящей БД?

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
В папке `Examples/DatabaseConnection/` лежат две версии кода:
- `Dirty/UserService.php` (Жесткая зависимость от MySQLDatabase)
- `Clean/` (Абстракция DatabaseInterface, внедрение зависимостей)

### 🧪 Как это тестировать?
С грязным кодом тесты невозможны без поднятия Docker с MySQL. 
С чистым кодом (DIP) вы передаете тестовую "заглушку" в класс и тестируете бизнес-логику за миллисекунды:

```php
public function testServiceReturnsUser(): void
{
    // FakeDatabase реализует DatabaseInterface, но работает с массивом в ОЗУ
    $fakeDb = new FakeDatabase(['id' => 1, 'name' => 'Test User']);
    
    $service = new UserService($fakeDb);
    
    $this->assertEquals('Test User', $service->getUser(1)['name']);
}
```

Запуск:
```bash
php SOLID/5_DIP/Examples/DatabaseConnection/Dirty/UserService.php
php SOLID/5_DIP/Examples/DatabaseConnection/Clean/index.php
```

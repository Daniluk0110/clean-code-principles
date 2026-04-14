# SOLID Principles 🧱

SOLID — это аббревиатура пяти принципов проектирования, которые делают программное обеспечение более понятным, гибким и поддерживаемым.

## Содержание

### 1. [SRP — Single Responsibility Principle](1_SRP/README.md)
*Принцип единственной ответственности.*
У класса должна быть только одна причина для изменения.
- [**Order Processing Example**](1_SRP/Examples/OrderProcessing/)
- [**User Authentication Example**](1_SRP/Examples/UserAuthentication/) (New!)

### 2. [OCP — Open-Closed Principle](2_OCP/README.md)
*Принцип открытости/закрытости.*
Программные сущности должны быть открыты для расширения, но закрыты для модификации.
- [**Payment Processing Example**](2_OCP/Examples/PaymentProcessing/)
- [**Discount Calculation Example**](2_OCP/Examples/ExtensibleDiscountCalculator/)
- [**Report Exporting Example**](2_OCP/Examples/ReportExporting/) (New!)

### 3. [LSP — Liskov Substitution Principle](3_LSP/README.md)
*Принцип подстановки Барбары Лисков.*
Объекты в программе должны быть заменяемыми на экземпляры их подтипов без изменения правильности выполнения программы.
- [**Storage Example**](3_LSP/Examples/Storage/)

### 4. [ISP — Interface Segregation Principle](4_ISP/README.md)
*Принцип разделения интерфейса.*
Много специализированных интерфейсов лучше, чем один универсальный.
- [**Cloud Services Example**](4_ISP/Examples/CloudServices/)

### 5. [DIP — Dependency Inversion Principle](5_DIP/README.md)
*Принцип инверсии зависимостей.*
Зависимости должны строиться на абстракциях, а не на конкретике.
- [**Database Connection Example**](5_DIP/Examples/DatabaseConnection/)

### 6. [All Together](6-All-Together/)
Пример, объединяющий все принципы в одном небольшом приложении.

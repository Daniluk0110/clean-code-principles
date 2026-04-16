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

function backupData(FileStorage $storage) {
    // Эта функция ожидает, что любой FileStorage умеет писать данные.
    // Если мы передадим сюда ReadOnlyStorage, приложение упадет с ошибкой в рантайме.
    $storage->write('/backup/data.txt', 'some data');
}

$storage = new ReadOnlyStorage();
backupData($storage);

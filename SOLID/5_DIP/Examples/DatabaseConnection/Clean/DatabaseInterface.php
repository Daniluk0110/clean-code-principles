<?php

declare(strict_types=1);

interface DatabaseInterface
{
    public function fetchUserById(int $id): array;
}

<?php

declare(strict_types=1);

namespace MeaningfulNaming\Examples\Variables\Good;

final class TaskManager
{
    private const SECONDS_IN_DAY = 86400;
    private const EXPIRATION_DAYS = 7;
    private const STATUS_ACTIVE = 1;

    /**
     * Код читается как рассказ. Имена констант и переменных 
     * объясняют бизнес-логику без комментариев.
     */
    public function getExpiredTasks(array $tasks): array
    {
        $expiredTasks = [];
        $currentTime = time();
        $expirationPeriodInSeconds = self::SECONDS_IN_DAY * self::EXPIRATION_DAYS;

        foreach ($tasks as $task) {
            $isTaskActive = $task['status'] === self::STATUS_ACTIVE;
            $secondsSinceLastUpdate = $currentTime - $task['last_updated_at'];

            if ($isTaskActive && $secondsSinceLastUpdate > $expirationPeriodInSeconds) {
                $expiredTasks[] = $task;
            }
        }

        return $expiredTasks;
    }
}

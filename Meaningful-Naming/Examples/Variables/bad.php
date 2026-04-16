<?php

declare(strict_types=1);

namespace MeaningfulNaming\Examples\Variables\Bad;

final class TaskManager
{
    /**
     * Проблема: Использование неясных сокращений и магических чисел.
     * Что такое $d? Что такое 86400? Что такое 7?
     */
    public function getExpiredTasks(array $tasks): array
    {
        $res = [];
        $t = time();
        $d = 86400; // Секунд в сутках?

        foreach ($tasks as $i) {
            if ($i['s'] === 1 && ($t - $i['u']) > ($d * 7)) {
                $res[] = $i;
            }
        }

        return $res;
    }
}

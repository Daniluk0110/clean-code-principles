<?php

namespace KISS\Examples\DateFormatting;

class SimpleDateFormatter
{
    /**
     * Simpler way to format a date using built-in or well-known library methods.
     */
    public function formatRelativeDate(\DateTime $date): string
    {
        // Keep it simple: use standard formatting unless relative time is strictly required.
        // If relative time is needed, use a dedicated library like Carbon instead of custom logic.
        return $date->format('Y-m-d H:i');
    }
}

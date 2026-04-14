<?php

namespace KISS\Examples\DateFormatting;

class DateFormatter
{
    /**
     * Over-engineered way to format a date.
     */
    public function formatRelativeDate(\DateTime $date): string
    {
        $now = new \DateTime();
        $diff = $now->getTimestamp() - $date->getTimestamp();

        if ($diff < 60) {
            return "just now";
        }

        $units = [
            'year'   => 31536000,
            'month'  => 2592000,
            'week'   => 604800,
            'day'    => 86400,
            'hour'   => 3600,
            'minute' => 60,
            'second' => 1
        ];

        foreach ($units as $unit => $seconds) {
            if ($diff >= $seconds) {
                $count = floor($diff / $seconds);
                return $count . ' ' . $unit . ($count > 1 ? 's' : '') . ' ago';
            }
        }

        return $date->format('Y-m-d');
    }
}

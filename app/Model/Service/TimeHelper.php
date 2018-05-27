<?php

namespace App\Model\Service;

class TimeHelper
{
    public static function getHoursIntervalAsString(float $hoursAndMinutes): string
    {
        $hours = (int)$hoursAndMinutes;
        $minutes = 60 * ($hoursAndMinutes - $hours);
        return sprintf('%d hours %d minutes', $hours, $minutes);
    }
}
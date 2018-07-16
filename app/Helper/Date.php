<?php

namespace App\Helper;

use Carbon\Carbon;

class Date
{
    const DEFAULT_DATE_FORMAT = 'd.m.Y';
    const DEFAULT_DATETIME_FORMAT = 'd.m.Y H:i:s';

    public static function formatDateTime($date, $format = null)
    {
        $format = (null === $format) ? self::DEFAULT_DATETIME_FORMAT : $format;
        $result = Carbon::parse($date)->format($format);
        return $result;
    }

    public static function formatDate($date, $format = null)
    {
        $format = (null === $format) ? self::DEFAULT_DATE_FORMAT : $format;
        $result = Carbon::parse($date)->format($format);
        return $result;
    }

}
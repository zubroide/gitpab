<?php

namespace App\Helper;

class Text
{

    public static function camelCaseToUnderscore(string $string): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }

}
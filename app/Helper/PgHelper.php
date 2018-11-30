<?php

namespace App\Helper;

use Exception;

class PgHelper
{
    public static function arrayParse($arraystring, $reset = true)
    {
        static $i = 0;
        if ($reset) $i = 0;

        $matches = array();
        $indexer = 1;   // by default sql arrays start at 1

        // handle [0,2]= cases
        if (preg_match('/^\[(?P<index_start>\d+):(?P<index_end>\d+)]=/', mb_substr($arraystring, $i), $matches))
        {
            $indexer = (int)$matches['index_start'];
            $i = mb_strpos($arraystring, '{');
        }

        if ($arraystring[$i] != '{')
        {
            return NULL;
        }

        if (is_array($arraystring)) return $arraystring;

        // handles btyea and blob binary streams
        if (is_resource($arraystring)) return fread($arraystring, 4096);

        $i++;
        $work = array();
        $curr = '';
        $length = mb_strlen($arraystring);
        $count = 0;
        $quoted = false;

        while ($i < $length)
        {
            // echo "\n [ $i ] ..... $arraystring[$i] .... $curr";

            switch (mb_substr($arraystring, $i, 1))
            {
                case '{':
                    $sub = self::arrayParse($arraystring, false);
                    if (!empty($sub))
                    {
                        $work[$indexer++] = $sub;
                    }
                    break;
                case '}':
                    $i++;
                    if (mb_strlen($curr) > 0) $work[$indexer++] = $curr;
                    return $work;
                    break;
                case '\\':
                    $i++;
                    $curr .= mb_substr($arraystring, $i, 1);
                    $i++;
                    break;
                case '"':
                    $quoted = true;
                    $openq = $i;
                    do
                    {
                        $closeq = mb_strpos($arraystring, '"', $i + 1);
                        $escaped = $closeq > $openq &&
                            preg_match('/(\\\\+)$/', mb_substr($arraystring, $openq + 1, $closeq - ($openq + 1)), $matches) &&
                            (mb_strlen($matches[1]) % 2);
                        if ($escaped)
                        {
                            $i = $closeq;
                        }
                        else
                        {
                            break;
                        }
                    } while (true);

                    if ($closeq <= $openq)
                    {
                        throw new Exception('Unexpected condition');
                    }

                    $curr .= mb_substr($arraystring, $openq + 1, $closeq - ($openq + 1));

                    $i = $closeq + 1;
                    break;
                case ',':
                    if (mb_strlen($curr) > 0)
                    {
                        if (!$quoted && (mb_strtoupper($curr) == 'NULL')) $curr = null;
                        $work[$indexer++] = $curr;
                    }
                    $curr = '';
                    $quoted = false;
                    $i++;
                    break;
                default:
                    $curr .= mb_substr($arraystring, $i, 1);
                    $i++;
            }
        }

        throw new Exception('Unexpected line end: ' . $curr);
    }

    /**
     * @param array $arr
     * @return string
     */
    public static function toPgArray(array $arr)
    {
        return '{' . implode(',', $arr) . '}';
    }
}
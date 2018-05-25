<?php

namespace App\Model\Service\Eloquent;

use App\Model\Service\ServiceException;

class EloquentNoteService extends EloquentServiceAbstract
{
    /**
     * @param \Traversable $list
     * @return array
     * @throws ServiceException
     */
    public function parseSpentTime(\Traversable $list)
    {
        $data = [];
        foreach ($list as $item) {
            $hours = 0;
            $pattern = '/added ((\d{1,3}[hm])\s)+of time spent at \d{4}-\d{2}-\d{2}/';
            preg_match($pattern, $item->body, $match);
            if (!empty($match)) {
                $times = explode(' ', $match[2]);
                foreach ($times as $time) {
                    $hours += $this->parseTime($time);
                }
            }
            $row = [
                'gitlab_created_at' => $item->gitlab_created_at,
                'hours' => $hours,
                'description' => $item->body,
            ];
            $data[] = $row;
        }
        return $data;
    }

    /**
     * @param $time
     * @return float|int
     * @throws ServiceException
     */
    protected function parseTime($time)
    {
        $value = mb_substr($time, 0, -1);
        $period = mb_substr($time, -1);
        if ($period === 'm') {
            return $value / 60;
        }
        if ($period === 'h') {
            return $value;
        }
        throw new ServiceException(sprintf('Unknown period %s (time %s)', $period, $time));
    }
}
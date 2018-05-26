<?php

namespace App\Model\Service\Eloquent;

use App\Model\Entity\Note;
use App\Model\Service\ServiceException;
use Illuminate\Support\Collection;

class EloquentNoteService extends EloquentServiceAbstract
{
    /**
     * @param \Traversable $list
     * @return Collection
     * @throws ServiceException
     */
    public function parseSpentTime(\Traversable $list)
    {
        $data = new Collection();

        /** @var Note $prev */
        $prev = null;

        /** @var Note $item */
        foreach ($list as $item) {
            $hours = 0;

            $pattern = '/added ((\d{1,3}[hm])\s+)+of time spent at \d{4}-\d{2}-\d{2}/';
            preg_match($pattern, $item->body, $match);

            if (!empty($match)) {
                $times = explode(' ', $match[2]);
                foreach ($times as $time) {
                    $hours += $this->parseTime($time);
                }
            }

            // Get description from previous comment if its corresponds to
            $description = null;
            if ($prev !== null) {
                $date1 = new \DateTime($prev->gitlab_created_at);
                $date2 = new \DateTime($item->gitlab_created_at);
                if ($prev->author_id == $item->author_id
                    && $prev->issue_id == $item->issue_id
                    && $date1->add(new \DateInterval('PT10S')) > $date2
                ) {
                    $description = $prev->body;
                }
            }

            $row = [
                'note_id' => $item->id,
                'gitlab_created_at' => $item->gitlab_created_at,
                'hours' => $hours,
                'description' => $description,
            ];

            if ($hours > 0) {
                $data->push($row);
            }

            $prev = $item;
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
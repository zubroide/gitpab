<?php

namespace App\Model\Service\Eloquent;

use App\Model\Entity\Note;
use App\Model\Repository\NoteRepositoryEloquent;
use App\Model\Service\ServiceException;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Collection;

/**
 * @property NoteRepositoryEloquent $repository
 */
class EloquentNoteService extends CrudServiceAbstract
{
    use StoreContributorsTrait;

    public function __construct()
    {
        $this->repository = app(AppServiceProvider::NOTE_REPOSITORY);
    }

    /**
     * @inheritdoc
     */
    public function storeList(Collection $list)
    {
        $this->storeContributors($list, ['author']);
        parent::storeList($list);
    }

    /**
     * @param \Traversable $list
     * @return Collection
     * @throws ServiceException
     * @throws \Exception
     */
    public function parseSpentTime(\Traversable $list)
    {
        $data = new Collection();

        /** @var Note $prev */
        $prev = null;

        /** @var Note $item */
        foreach ($list as $item) {
            $row = $this->parseSpentTimeItem($item, $prev);

            if ($row['hours'] !== 0) {
                $data->push($row);
            }

            $prev = $item;
        }

        return $data;
    }

    /**
     * @param Note $item
     * @param Note $prev
     * @return array
     * @throws ServiceException
     * @throws \Exception
     */
    protected function parseSpentTimeItem(Note $item, Note $prev = null): array
    {
        $hours = 0;
        $spentAt = null;

        $pattern = '/(added|subtracted) ((?:(?:\d{1,3}[wdhms])\s+)+)of time spent( at (\d{4}-\d{2}-\d{2}))?/';
        preg_match($pattern, $item->body, $match);

        if (!empty($match) && (count($match) === 5 || count($match) === 3)) {
            $sign = $match[1] === 'added' ? 1 : -1;
            $times = array_filter(explode(' ', $match[2]));
            foreach ($times as $time) {
                $hours += $sign * $this->parseTime(trim($time));
            }
            $spentAt = $match[4] ?? $item->gitlab_created_at;
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
            'spent_at' => $spentAt,
            'gitlab_created_at' => $item->gitlab_created_at,
            'hours' => $hours,
            'description' => $description,
        ];
        return $row;
    }

    /**
     * @param string $time
     * @return float|int
     * @throws ServiceException
     */
    protected function parseTime(string $time)
    {
        $value = mb_substr($time, 0, -1);
        $period = mb_substr($time, -1);
        if ($period === 's') {
            return $value / 3600;
        }
        if ($period === 'm') {
            return $value / 60;
        }
        if ($period === 'h') {
            return $value;
        }
        if ($period === 'd') {
            return $value * 8;
        }
        if ($period === 'w') {
            return $value * 8 * 5;
        }
        throw new ServiceException(sprintf('Unknown period %s (time %s)', $period, $time));
    }

}
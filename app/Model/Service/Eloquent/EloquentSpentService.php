<?php

namespace App\Model\Service\Eloquent;

use App\Model\Entity\Note;
use App\Model\Entity\Spent;
use App\Model\Repository\NoteRepositoryEloquent;
use App\Model\Repository\SpentRepositoryEloquent;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @property SpentRepositoryEloquent $repository
 */
class EloquentSpentService extends CrudServiceAbstract
{
    const DEFAULT_ORDER_COLUMN = 'note.gitlab_created_at';

    public function __construct()
    {
        $this->repository = app(AppServiceProvider::SPENT_REPOSITORY);
    }

    public function stat(array $parameters): Collection
    {
        return $this->repository->stat($parameters);
    }

    public function getTotalTime(array $parameters)
    {
        $query = $this->repository->getListQuery($parameters);
        $query->select(DB::raw('sum(hours) as total'));
        return $query->first()->total;
    }

    public function getTNMList($parameters)
    {
        $query = $this->repository->getTNMListQuery($parameters);
        return $query->cursor();
    }

    public function getTNMLabelsList($parameters)
    {
        $query = $this->repository->getTNMLabelsListQuery($parameters);
        return $query->cursor();
    }

    public function removeTimeSpend(int $issueId, $at)
    {
        /** @var Spent[] $spent */
        $spent = $this->repository->with('note')->findWhere([
            'issue_id' => $issueId,
        ]);
        $spentByUsers = [];
        foreach ($spent as $spentRow) {
            $spentByUsers[$spentRow->note->author_id] = ($spentByUsers[$spentRow->note->author_id] ?? 0) + $spentRow->hours;
        }

        foreach ($spentByUsers as $userId => $hours) {
            if ($hours <= 0) {
                continue;
            }
            /** @var NoteRepositoryEloquent $noteRepo */
            $noteRepo = app(AppServiceProvider::NOTE_REPOSITORY);
            /** @var Note $note */
            $note = $noteRepo->create([
                'issue_id' => $issueId,
                'body' => 'remove time spent message processed',
                'author_id' => $userId,
                'gitlab_created_at' => $at,
            ]);
            $this->create([
                'note_id' => $note->id,
                'description' => 'remove time spent',
                'spent_at' => $at,
                'hours' => -$hours,
            ]);
        }
    }

}
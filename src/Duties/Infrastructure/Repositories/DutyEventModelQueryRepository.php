<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\Repositories;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Modules\Duties\Infrastructure\DataAccess\DutyEventModel;
use Modules\Duties\Infrastructure\DataAccess\QueryFilters;

final readonly class DutyEventModelQueryRepository
{
    public function __construct(
        private Pipeline $pipeline,
    ) {
    }

    public function getAll(Collection $filters, Collection $sorts): Collection
    {
        $query = DutyEventModel::query()->with('duty');

        $pipes = [
            new QueryFilters\DutyEventTypeQueryFilter($filters, $sorts),
            new QueryFilters\DutyEventDateQueryFilter($filters, $sorts),
            new QueryFilters\DutyEventFromFilter($filters, $sorts),
            new QueryFilters\DutyEventSortQueryFilter($filters, $sorts),
        ];

        return $this->pipeline
            ->send($query)
            ->through($pipes)
            ->thenReturn()
            ->get();
    }
}

<?php

declare(strict_types=1);

namespace Modules\Duties\Application\UseCases\DutyEvents;

use Illuminate\Support\Collection;
use Modules\Duties\Infrastructure\DataAccess\DutyEventModel;
use Modules\Duties\Infrastructure\Repositories\DutyEventModelQueryRepository;

final readonly class DutyEventsQueryHandler
{
    public function __construct(
        private DutyEventModelQueryRepository $repository,
    ) {
    }

    public function handle(DutyEventsQuery $query): Collection
    {
        return $this->repository->getAll($query->filters, $query->sorts)
            ->map(fn (DutyEventModel $model) => new DutyEvent(
                id: $model->id,
                baseDate: $model->duty->date->toDateString(),
                from: $model->duty->from,
                to: $model->duty->to,
                type: $model->type->value,
                checkIn: $model->duty->check_in?->toDateTimeString(),
                checkOut: $model->duty->check_out?->toDateTimeString(),
                departure: $model->duty->departure_at?->toDateTimeString(),
                arrival: $model->duty->arrival_at?->toDateTimeString(),
            ))
            ->values();
    }
}

<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\Repositories;

use Illuminate\Support\Str;
use Modules\Duties\Domain\Duty;
use Modules\Duties\Domain\Enums\DutyEventEnum;
use Modules\Duties\Domain\Repositories\DutyInsertRepositoryInterface;
use Modules\Duties\Infrastructure\DataAccess\DutyModel;

final readonly class DutyModelInsertRepository implements DutyInsertRepositoryInterface
{
    public function save(Duty $duty): void
    {
        $model = DutyModel::query()->whereKey($duty->getId())->firstOrNew();

        $model->events()->delete();

        $model->id = $duty->getId();
        $model->type = $duty->getType();
        $model->date = $duty->getDate()->toString();
        $model->check_in = $duty->getCheck()->in;
        $model->check_out = $duty->getCheck()->out;
        $model->flight = $duty->getFlight()->raw();
        $model->departure_at = $duty->getPeriod()->departure;
        $model->arrival_at = $duty->getPeriod()->arrival;
        $model->duration = $duty->getPeriod()->toInt();
        $model->from = $duty->getLocation()->from;
        $model->to = $duty->getLocation()->to;
        $model->save();

        $model->events()->createMany(array_map(static fn (DutyEventEnum $event) => [
            'id' => Str::uuid()->toString(),
            'duty_id' => $model->id,
            'type' => $event->value,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ], $duty->getEvents()));
    }
}

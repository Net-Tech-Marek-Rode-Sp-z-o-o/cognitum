<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\DataAccess\QueryFilters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

final class DutyEventDateQueryFilter extends AbstractQueryFilter
{
    public function handle(Builder $query, \Closure $next): Builder
    {
        if (! $this->filters->has('date')) {
            return $next($query);
        }

        $dates = collect($this->filters->get('date'));

        $start = strtotime(datetime: (string) ($dates->get('start') ?? $dates->first()));
        $end = strtotime(datetime: (string) ($dates->get('end') ?? $dates->last()));

        if ($start && $end) {
            $query->whereHas('duty', function ($q) use ($start, $end) {
                $q->whereBetween('date', [
                    Carbon::createFromTimestamp($start)->startOfDay(),
                    Carbon::createFromTimestamp($end)->endOfDay(),
                ]);
            });
        }

        return $next($query);
    }
}

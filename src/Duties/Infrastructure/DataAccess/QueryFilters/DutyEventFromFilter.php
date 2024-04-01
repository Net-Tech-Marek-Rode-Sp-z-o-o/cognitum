<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\DataAccess\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

final class DutyEventFromFilter extends AbstractQueryFilter
{
    public function handle(Builder $query, \Closure $next): Builder
    {
        if ($this->filters->has('from')) {
            $query->whereHas('duty', function ($q) {
                $q->where('from', $this->filters->get('from'));
            });
        }

        return $next($query);
    }
}

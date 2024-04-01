<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\DataAccess\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

final class DutyEventSortQueryFilter extends AbstractQueryFilter
{
    public function handle(Builder $query, \Closure $next): Builder
    {
        if ($this->sorts->isEmpty()) {
            $query->latest();

            return $next($query);
        }

        foreach ($this->sorts->all() as $sorts) {
            $sort = collect($sorts);

            if ($sort->has('column', 'sort')) {
                $query->orderBy($sort->get('column'), $sort->get('sort'));
            }
        }

        return $next($query);
    }
}

<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\DataAccess\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Duties\Domain\Enums\DutyEventEnum;

final class DutyEventTypeQueryFilter extends AbstractQueryFilter
{
    public function handle(Builder $query, \Closure $next): Builder
    {
        if (! $this->filters->has('types')) {
            return $next($query);
        }

        /** @var Collection $types */
        $types = collect($this->filters->get('types'))
            ->map(fn (string $type) => DutyEventEnum::tryFrom($type)?->value)
            ->filter()
            ->values();

        if ($types->isNotEmpty()) {
            $query->whereIn('duties_events.type', $types);
        }

        return $next($query);
    }
}

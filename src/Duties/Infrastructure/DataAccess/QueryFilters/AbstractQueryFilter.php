<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\DataAccess\QueryFilters;

use Illuminate\Support\Collection;

abstract class AbstractQueryFilter
{
    public function __construct(
        protected Collection $filters,
        protected Collection $sorts,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace Modules\Duties\Application\UseCases\DutyEvents;

use Component\Bus\QueryBus\QueryHandler;
use Component\Bus\QueryBus\QueryInterface;
use Illuminate\Support\Collection;

#[QueryHandler(DutyEventsQueryHandler::class)]
final readonly class DutyEventsQuery implements QueryInterface
{
    public function __construct(
        public Collection $filters,
        public Collection $sorts,
    ) {
    }
}

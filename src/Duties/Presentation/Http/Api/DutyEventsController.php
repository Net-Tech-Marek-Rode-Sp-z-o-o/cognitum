<?php

declare(strict_types=1);

namespace Modules\Duties\Presentation\Http\Api;

use Component\Bus\QueryBus\QueryBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Duties\Application\UseCases\DutyEvents\DutyEventsQuery;
use Modules\Duties\Presentation\Http\Resources\DutyEventResource;

final readonly class DutyEventsController
{
    public function __construct(
        private QueryBus $queryBus,
        private DutyEventResource $resource,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $collection = $this->queryBus->handle(new DutyEventsQuery(
            filters: collect($request->query('filters', [])),
            sorts: collect($request->query('sorts_by', [])),
        ));

        return new JsonResponse($this->resource->toArray($collection));
    }
}

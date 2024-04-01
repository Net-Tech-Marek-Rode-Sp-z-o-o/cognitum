<?php

declare(strict_types=1);

namespace Modules\Duties\Presentation\Http\Resources;

use Illuminate\Support\Collection;

final readonly class DutyEventResource
{
    public function toArray(Collection $events): array
    {
        return [
            'events' => $events->toArray(),
        ];
    }
}

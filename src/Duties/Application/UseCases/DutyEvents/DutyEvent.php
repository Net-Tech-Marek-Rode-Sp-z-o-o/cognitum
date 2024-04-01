<?php

declare(strict_types=1);

namespace Modules\Duties\Application\UseCases\DutyEvents;

use Illuminate\Contracts\Support\Arrayable;

final readonly class DutyEvent implements Arrayable
{
    public function __construct(
        public string $id,
        public string $baseDate,
        public ?string $from,
        public ?string $to,
        public string $type,
        public ?string $checkIn,
        public ?string $checkOut,
        public ?string $departure,
        public ?string $arrival,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->baseDate,
            'from' => $this->from,
            'to' => $this->to,
            'type' => $this->type,
            'check_in' => $this->checkIn,
            'check_out' => $this->checkOut,
            'departure' => $this->departure,
            'arrival' => $this->arrival,
        ];
    }
}

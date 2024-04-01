<?php

declare(strict_types=1);

namespace Modules\Duties\Domain\ValueObject;

use Carbon\CarbonInterface;
use InvalidArgumentException;

final readonly class DutyPeriod
{
    public function __construct(
        public CarbonInterface $departure,
        public CarbonInterface $arrival,
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->departure->greaterThan($this->arrival)) {
            throw new InvalidArgumentException('Departure date must be earlier than arrival date');
        }
    }

    public function toInt(): int
    {
        return $this->departure->diffInMinutes($this->arrival);
    }
}

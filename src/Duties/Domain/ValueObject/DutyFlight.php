<?php

declare(strict_types=1);

namespace Modules\Duties\Domain\ValueObject;

final readonly class DutyFlight
{
    public function __construct(
        private ?string $flight,
    ) {
    }

    public function raw(): ?string
    {
        return $this->flight;
    }
}

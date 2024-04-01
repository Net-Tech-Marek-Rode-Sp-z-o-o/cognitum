<?php

declare(strict_types=1);

namespace Modules\Duties\Domain\ValueObject;

use Carbon\CarbonInterface;
use Stringable;

final readonly class DutyDate implements Stringable
{
    public function __construct(
        public CarbonInterface $date,
    ) {
    }

    public function toString(): string
    {
        return (string) $this;
    }

    public function __toString(): string
    {
        return $this->date->toDateString();
    }
}

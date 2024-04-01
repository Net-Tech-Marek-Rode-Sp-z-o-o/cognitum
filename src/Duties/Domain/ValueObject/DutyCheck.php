<?php

declare(strict_types=1);

namespace Modules\Duties\Domain\ValueObject;

use Carbon\CarbonInterface;
use InvalidArgumentException;

final readonly class DutyCheck
{
    public function __construct(
        public ?CarbonInterface $in,
        public ?CarbonInterface $out,
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if (! $this->in || ! $this->out) {
            return;
        }

        if ($this->in->greaterThan($this->out)) {
            throw new InvalidArgumentException('Check in date must be earlier than out date');
        }
    }
}

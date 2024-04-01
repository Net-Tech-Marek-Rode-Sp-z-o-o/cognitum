<?php

declare(strict_types=1);

namespace Modules\Duties\Domain\ValueObject;

final readonly class DutyLocation
{
    public function __construct(
        public ?string $from,
        public ?string $to,
    ) {
    }
}

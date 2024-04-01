<?php

declare(strict_types=1);

namespace Modules\Documents\Domain\ValueObjects;

final readonly class DocumentSize
{
    public function __construct(
        private int $size,
    ) {
    }

    public function toInt(): int
    {
        return $this->size;
    }
}

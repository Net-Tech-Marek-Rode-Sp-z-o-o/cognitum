<?php

declare(strict_types=1);

namespace Modules\Documents\Domain\ValueObjects;

use Stringable;

final readonly class DocumentName implements Stringable
{
    public function __construct(
        private string $name,
    ) {
    }

    public function toString(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}

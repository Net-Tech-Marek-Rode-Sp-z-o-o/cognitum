<?php

declare(strict_types=1);

namespace Modules\Documents\Domain\ValueObjects;

use Stringable;

final readonly class DocumentPath implements Stringable
{
    public function __construct(
        private string $path,
    ) {
    }

    public function toString(): string
    {
        return $this->path;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}

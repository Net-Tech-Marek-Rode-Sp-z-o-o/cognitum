<?php

declare(strict_types=1);

namespace Modules\Documents\Domain\ValueObjects;

use Stringable;

final readonly class DocumentMime implements Stringable
{
    public function __construct(
        private string $mime,
    ) {
    }

    public function toString(): string
    {
        return $this->mime;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}

<?php

declare(strict_types=1);

namespace Modules\Duties\Domain\ValueObject;

use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Stringable;

final readonly class DutyId implements Stringable
{
    public function __construct(
        private UuidInterface $id,
    ) {
    }

    public static function getNew(): self
    {
        return new self(Str::uuid());
    }

    public static function fromString(string $id): self
    {
        return new self(Uuid::fromString($id));
    }

    public function toString(): string
    {
        return (string) $this->id;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}

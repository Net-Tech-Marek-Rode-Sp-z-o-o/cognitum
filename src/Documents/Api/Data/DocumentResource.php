<?php

declare(strict_types=1);

namespace Modules\Documents\Api\Data;

final readonly class DocumentResource
{
    public function __construct(
        private ?DocumentData $data = null,
        private ?string $error = null,
    ) {
    }

    public function isSuccessful(): bool
    {
        return $this->error === null;
    }

    public function getData(): ?DocumentData
    {
        return $this->data;
    }

    public function getError(): ?string
    {
        return $this->error;
    }
}

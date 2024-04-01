<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\Adapters;

interface DocumentAdapterInterface
{
    public function readDocument(string $documentId): string;

    public function removeDocument(string $documentId): void;
}

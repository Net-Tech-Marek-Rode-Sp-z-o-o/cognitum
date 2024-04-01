<?php

declare(strict_types=1);

namespace Tests\Mocks\Duties;

use Modules\Duties\Infrastructure\Adapters\DocumentAdapterInterface;

final class MockDocumentAdapter implements DocumentAdapterInterface
{
    public function readDocument(string $documentId): string
    {
        return file_get_contents(__DIR__.'/../../fixtures/dtr.html');
    }

    public function removeDocument(string $documentId): void
    {
        // do nothing
    }
}

<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\Adapters;

use Modules\Documents\Api\DocumentFacadeInterface;

final readonly class DocumentAdapter implements DocumentAdapterInterface
{
    public function __construct(
        private DocumentFacadeInterface $documentFacade,
    ) {

    }

    public function readDocument(string $documentId): string
    {
        $resource = $this->documentFacade->getDocument($documentId);

        return $resource->getData()?->content ?? '';
    }

    public function removeDocument(string $documentId): void
    {
        $this->documentFacade->deleteDocument($documentId);
    }
}

<?php

declare(strict_types=1);

namespace Modules\Documents\Application\Facades;

use Modules\Documents\Api\Data\DocumentData;
use Modules\Documents\Api\Data\DocumentResource;
use Modules\Documents\Api\DocumentFacadeInterface;
use Modules\Documents\Application\Services\DocumentStorageServiceInterface;
use Modules\Documents\Domain\Exceptions\DocumentNotFoundException;
use Modules\Documents\Domain\Repositories\DocumentInsertRepositoryInterface;
use Modules\Documents\Domain\Repositories\DocumentReadRepositoryInterface;
use Modules\Documents\Domain\ValueObjects\DocumentId;

final readonly class DocumentFacade implements DocumentFacadeInterface
{
    public function __construct(
        private DocumentReadRepositoryInterface $documentReadRepository,
        private DocumentStorageServiceInterface $documentStorageService,
        private DocumentInsertRepositoryInterface $documentInsertRepository,
    ) {
    }

    public function getDocument(string $id): DocumentResource
    {
        try {
            $document = $this->documentReadRepository->find(DocumentId::fromString($id));
            $content = $this->documentStorageService->getContent($document->getPath()->toString());

            $data = new DocumentData(
                id: $document->getId()->toString(),
                fileName: $document->getOriginalName()->toString(),
                content: $content,
            );

            return new DocumentResource(
                data: $data,
            );
        } catch (DocumentNotFoundException $exception) {
            return new DocumentResource(
                error: $exception->getMessage(),
            );
        }
    }

    public function deleteDocument(string $id): DocumentResource
    {
        try {
            $document = $this->documentReadRepository->find(DocumentId::fromString($id));

            $this->documentStorageService->remove($document->getPath()->toString());

            $this->documentInsertRepository->delete($document);

            return new DocumentResource();
        } catch (DocumentNotFoundException $exception) {
            return new DocumentResource(
                error: $exception->getMessage(),
            );
        }
    }
}

<?php

declare(strict_types=1);

namespace Modules\Documents\Application\UseCases\UploadDocument;

use Modules\Documents\Application\Services\DocumentStorageServiceInterface;
use Modules\Documents\Domain\Document;
use Modules\Documents\Domain\Repositories\DocumentInsertRepositoryInterface;

final readonly class UploadDocumentCommandHandler
{
    public function __construct(
        private DocumentStorageServiceInterface $documentStorageService,
        private DocumentInsertRepositoryInterface $documentInsertRepository,
    ) {
    }

    public function handle(UploadDocumentCommand $command): void
    {
        $path = $this->documentStorageService->store($command->file);

        $document = Document::new($command->id, $command->file, $path)->on(
            disk: $this->documentStorageService->getDisk(),
        );

        $this->documentInsertRepository->save($document);
    }
}

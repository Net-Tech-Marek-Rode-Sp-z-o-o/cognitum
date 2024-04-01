<?php

declare(strict_types=1);

namespace Tests\Unit\Documents\UseCases;

use Illuminate\Http\UploadedFile;
use Modules\Documents\Application\UseCases\UploadDocument\UploadDocumentCommand;
use Modules\Documents\Application\UseCases\UploadDocument\UploadDocumentCommandHandler;
use Modules\Documents\Domain\Document;
use Modules\Documents\Domain\Exceptions\DocumentUploadException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Tests\Mocks\Documents\MockDocumentFailedStorageService;
use Tests\Mocks\Documents\MockDocumentInMemoryInsertRepository;
use Tests\Mocks\Documents\MockDocumentSuccessfulStorageService;

final class UploadDocumentCommandHandlerTest extends TestCase
{
    public function testUploadingDocument(): void
    {
        $handler = new UploadDocumentCommandHandler(
            documentStorageService: new MockDocumentSuccessfulStorageService(),
            documentInsertRepository: $documentInsertRepository = new MockDocumentInMemoryInsertRepository(),
        );

        $handler->handle($command = new UploadDocumentCommand(
            id: Uuid::uuid4(),
            file: UploadedFile::fake()->create('document.pdf', 1024),
        ));

        $this->assertInstanceOf(Document::class, $documentInsertRepository->getDocumentById(
            id: $command->id->toString(),
        ));
    }

    public function testFailingToUploadDocument(): void
    {
        $this->expectException(DocumentUploadException::class);

        $handler = new UploadDocumentCommandHandler(
            documentStorageService: new MockDocumentFailedStorageService(),
            documentInsertRepository: new MockDocumentInMemoryInsertRepository(),
        );

        $handler->handle(new UploadDocumentCommand(
            id: Uuid::uuid4(),
            file: UploadedFile::fake()->create('document.pdf', 1024),
        ));
    }
}

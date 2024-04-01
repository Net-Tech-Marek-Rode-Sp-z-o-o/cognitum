<?php

declare(strict_types=1);

namespace Tests\Feature\Documents\Repositories;

use Modules\Documents\Infrastructure\Repositories\DocumentModelInsertRepository;
use Tests\ObjectMothers\Documents\DocumentFactory;
use Tests\TestCase;

final class DocumentModelInsertRepositoryTest extends TestCase
{
    private DocumentModelInsertRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->make(DocumentModelInsertRepository::class);
    }

    public function testCreatingDocument(): void
    {
        $this->repository->save($document = DocumentFactory::fake());

        $this->assertDatabaseHas('documents', [
            'id' => $document->getId()->toString(),
            'name' => $document->getName()->toString(),
            'file_name' => $document->getOriginalName()->toString(),
            'mime_type' => $document->getMime()->toString(),
            'path' => $document->getPath()->toString(),
            'size' => $document->getSize()->toInt(),
            'disk' => $document->getDisk()->value,
        ]);
    }
}

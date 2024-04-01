<?php

declare(strict_types=1);

namespace Tests\Feature\Documents\Repositories;

use Illuminate\Support\Facades\Storage;
use Modules\Documents\Domain\Enums\DocumentDiskEnum;
use Modules\Documents\Domain\ValueObjects\DocumentId;
use Modules\Documents\Infrastructure\DataAccess\DocumentModel;
use Modules\Documents\Infrastructure\Repositories\DocumentModelReadRepository;
use Tests\TestCase;

final class DocumentModelReadRepositoryTest extends TestCase
{
    private DocumentModelReadRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake(DocumentDiskEnum::LOCAL->value);

        $this->repository = $this->app->make(DocumentModelReadRepository::class);
    }

    public function testFindingDocument(): void
    {
        $model = DocumentModel::factory()->create();

        $document = $this->repository->find(DocumentId::fromString($model->id));

        $this->assertEquals($model->id, $document->getId()->toString());
        $this->assertEquals($model->name, $document->getName()->toString());
        $this->assertEquals($model->file_name, $document->getOriginalName()->toString());
        $this->assertEquals($model->mime_type, $document->getMime()->toString());
        $this->assertEquals($model->path, $document->getPath()->toString());
        $this->assertEquals($model->size, $document->getSize()->toInt());
        $this->assertEquals($model->disk, $document->getDisk());
    }

    public function testNotFindingDocument(): void
    {
        $this->expectExceptionObject($this->repository->newDocumentNotFoundException());
        $this->repository->find(DocumentId::fromString($this->faker->uuid()));
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Documents\Facades;

use Illuminate\Support\Facades\Storage;
use Modules\Documents\Application\Facades\DocumentFacade;
use Modules\Documents\Domain\Enums\DocumentDiskEnum;
use Modules\Documents\Infrastructure\DataAccess\DocumentModel;
use Tests\TestCase;

final class DocumentFacadeTest extends TestCase
{
    private DocumentFacade $facade;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake(DocumentDiskEnum::LOCAL->value);

        $this->facade = $this->app->make(DocumentFacade::class);
    }

    public function testFindingDocument(): void
    {
        $model = DocumentModel::factory()->create();

        $resource = $this->facade->getDocument($model->id);

        $this->assertTrue($resource->isSuccessful());
        $this->assertEquals($model->id, $resource->getData()->id);
        $this->assertEquals($model->file_name, $resource->getData()->fileName);
    }

    public function testNotFindingDocument(): void
    {
        $resource = $this->facade->getDocument($this->faker->uuid());

        $this->assertFalse($resource->isSuccessful());
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\Documents\DomainModels;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;
use Modules\Documents\Application\Services\DocumentStorageServiceInterface;
use Modules\Documents\Domain\Document;
use Modules\Documents\Domain\Enums\DocumentDiskEnum;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Tests\ObjectMothers\Documents\DocumentFactory;

final class DocumentTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupFaker();
    }

    public function testCreatingNewDocument(): void
    {
        $id = Uuid::uuid4();
        $file = UploadedFile::fake()->create('document.pdf', 1024);

        $document = Document::new($id, $file, $path = DocumentStorageServiceInterface::PATH);

        $this->assertEquals($id->toString(), $document->getId());
        $this->assertEquals($file->hashName(), $document->getName());
        $this->assertEquals($file->getClientOriginalName(), $document->getOriginalName());
        $this->assertEquals($file->getClientMimeType(), $document->getMime());
        $this->assertEquals($path, $document->getPath());
        $this->assertEquals($file->getSize(), $document->getSize()->toInt());
        $this->assertEquals(DocumentDiskEnum::LOCAL, $document->getDisk());
    }

    public function testChangingStorage(): void
    {
        $document = DocumentFactory::fake();

        /** @var DocumentDiskEnum $disk */
        $disk = $this->faker->randomElement(DocumentDiskEnum::cases());

        $document->on($disk->value);

        $this->assertEquals($disk, $document->getDisk());
    }

    public function testFailingToChangeStorage(): void
    {
        $document = DocumentFactory::fake();

        $this->expectException(InvalidArgumentException::class);
        $document->on('s3');
    }
}

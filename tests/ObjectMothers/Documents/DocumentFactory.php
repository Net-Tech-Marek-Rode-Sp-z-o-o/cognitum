<?php

declare(strict_types=1);

namespace Tests\ObjectMothers\Documents;

use Illuminate\Http\UploadedFile;
use Modules\Documents\Application\Services\DocumentStorageServiceInterface;
use Modules\Documents\Domain\Document;
use Ramsey\Uuid\Uuid;

final readonly class DocumentFactory
{
    public static function fake(): Document
    {
        $id = Uuid::uuid4();

        $file = UploadedFile::fake()->create('document.pdf', 1024);

        return Document::new($id, $file, DocumentStorageServiceInterface::PATH);
    }
}

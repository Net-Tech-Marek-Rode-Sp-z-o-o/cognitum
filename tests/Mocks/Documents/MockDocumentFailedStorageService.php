<?php

declare(strict_types=1);

namespace Tests\Mocks\Documents;

use Illuminate\Http\UploadedFile;
use Modules\Documents\Application\Services\DocumentStorageServiceInterface;
use Modules\Documents\Domain\Enums\DocumentDiskEnum;
use Modules\Documents\Domain\Exceptions\DocumentUploadException;

final class MockDocumentFailedStorageService implements DocumentStorageServiceInterface
{
    public function store(UploadedFile $file): string
    {
        throw new DocumentUploadException();
    }

    public function remove(string $path): bool
    {
        return false;
    }

    public function getContent(string $path): string
    {
        return '';
    }

    public function getDisk(): string
    {
        return DocumentDiskEnum::LOCAL->value;
    }
}

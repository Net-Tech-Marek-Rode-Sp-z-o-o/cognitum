<?php

declare(strict_types=1);

namespace Tests\Mocks\Documents;

use Illuminate\Http\UploadedFile;
use Modules\Documents\Application\Services\DocumentStorageServiceInterface;
use Modules\Documents\Domain\Enums\DocumentDiskEnum;

final class MockDocumentSuccessfulStorageService implements DocumentStorageServiceInterface
{
    public function store(UploadedFile $file): string
    {
        return self::PATH.DIRECTORY_SEPARATOR.$file->hashName();
    }

    public function remove(string $path): bool
    {
        return true;
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

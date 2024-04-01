<?php

declare(strict_types=1);

namespace Modules\Documents\Infrastructure\Services;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Documents\Application\Services\DocumentStorageServiceInterface;
use Modules\Documents\Domain\Enums\DocumentDiskEnum;
use Modules\Documents\Domain\Exceptions\DocumentUploadException;

final readonly class DocumentFilesystemStorageService implements DocumentStorageServiceInterface
{
    public const PATH = 'documents';

    public function __construct(
        private Translator $translator,
    ) {
    }

    public function store(UploadedFile $file): string
    {
        return $file->store(self::PATH, $this->getDisk()) ?: throw $this->newDocumentUploadException();
    }

    public function remove(string $path): bool
    {
        return Storage::disk($this->getDisk())->delete($path);
    }

    public function getContent(string $path): string
    {
        return Storage::disk($this->getDisk())->get($path) ?: throw $this->newDocumentUploadException();
    }

    public function getDisk(): string
    {
        return DocumentDiskEnum::LOCAL->value;
    }

    private function newDocumentUploadException(): DocumentUploadException
    {
        return new DocumentUploadException(
            message: $this->translator->get('documents::exceptions.document_upload_error'),
        );
    }
}

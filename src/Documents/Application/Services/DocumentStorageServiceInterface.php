<?php

declare(strict_types=1);

namespace Modules\Documents\Application\Services;

use Illuminate\Http\UploadedFile;
use Modules\Documents\Domain\Exceptions\DocumentUploadException;

interface DocumentStorageServiceInterface
{
    public const PATH = 'documents';

    /**
     * @throws DocumentUploadException
     */
    public function store(UploadedFile $file): string;

    public function remove(string $path): bool;

    public function getContent(string $path): string;

    public function getDisk(): string;
}

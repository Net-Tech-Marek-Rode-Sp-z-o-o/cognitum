<?php

declare(strict_types=1);

namespace Modules\Documents\Domain;

use Illuminate\Http\UploadedFile;
use InvalidArgumentException;
use Ramsey\Uuid\UuidInterface;

final class Document
{
    public function __construct(
        private readonly ValueObjects\DocumentId $id,
        private readonly ValueObjects\DocumentName $name,
        private readonly ValueObjects\DocumentOriginalName $originalName,
        private readonly ValueObjects\DocumentMime $mime,
        private readonly ValueObjects\DocumentPath $path,
        private readonly ValueObjects\DocumentSize $size,
        private Enums\DocumentDiskEnum $disk,
    ) {
    }

    public static function new(UuidInterface $id, UploadedFile $file, string $path): self
    {
        return new self(
            id: new ValueObjects\DocumentId($id),
            name: new ValueObjects\DocumentName($file->hashName()),
            originalName: new ValueObjects\DocumentOriginalName($file->getClientOriginalName()),
            mime: new ValueObjects\DocumentMime($file->getClientMimeType()),
            path: new ValueObjects\DocumentPath($path),
            size: new ValueObjects\DocumentSize($file->getSize()),
            disk: Enums\DocumentDiskEnum::LOCAL,
        );
    }

    public function getId(): ValueObjects\DocumentId
    {
        return $this->id;
    }

    public function getName(): ValueObjects\DocumentName
    {
        return $this->name;
    }

    public function getOriginalName(): ValueObjects\DocumentOriginalName
    {
        return $this->originalName;
    }

    public function getMime(): ValueObjects\DocumentMime
    {
        return $this->mime;
    }

    public function getPath(): ValueObjects\DocumentPath
    {
        return $this->path;
    }

    public function getSize(): ValueObjects\DocumentSize
    {
        return $this->size;
    }

    public function getDisk(): Enums\DocumentDiskEnum
    {
        return $this->disk;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function on(string $disk): self
    {
        if ($newDisk = Enums\DocumentDiskEnum::tryFrom($disk)) {
            $this->disk = $newDisk;

            return $this;
        }

        throw new InvalidArgumentException(sprintf(
            'Disk %s is not supported for document storage.',
            $disk,
        ));
    }
}

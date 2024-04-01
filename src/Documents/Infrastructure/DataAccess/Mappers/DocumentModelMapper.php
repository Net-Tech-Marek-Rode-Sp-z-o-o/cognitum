<?php

declare(strict_types=1);

namespace Modules\Documents\Infrastructure\DataAccess\Mappers;

use Modules\Documents\Domain\Document;
use Modules\Documents\Domain\ValueObjects as VO;
use Modules\Documents\Infrastructure\DataAccess\DocumentModel;

final readonly class DocumentModelMapper
{
    public function fromModelToDomain(DocumentModel $model): Document
    {
        return new Document(
            id: VO\DocumentId::fromString($model->id),
            name: new VO\DocumentName($model->name),
            originalName: new VO\DocumentOriginalName($model->file_name),
            mime: new VO\DocumentMime($model->mime_type),
            path: new VO\DocumentPath($model->path),
            size: new VO\DocumentSize($model->size),
            disk: $model->disk,
        );
    }
}

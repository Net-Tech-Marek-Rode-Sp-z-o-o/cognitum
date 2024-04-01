<?php

declare(strict_types=1);

namespace Modules\Documents\Infrastructure\Repositories;

use Modules\Documents\Domain\Document;
use Modules\Documents\Domain\Repositories\DocumentInsertRepositoryInterface;
use Modules\Documents\Infrastructure\DataAccess\DocumentModel;

final readonly class DocumentModelInsertRepository implements DocumentInsertRepositoryInterface
{
    public function save(Document $document): void
    {
        $model = DocumentModel::query()->whereKey($document->getId()->toString())->firstOrNew();
        $model->id = $document->getId()->toString();
        $model->name = $document->getName()->toString();
        $model->file_name = $document->getOriginalName()->toString();
        $model->disk = $document->getDisk();
        $model->path = $document->getPath()->toString();
        $model->mime_type = $document->getMime()->toString();
        $model->size = $document->getSize()->toInt();
        $model->save();
    }

    public function delete(Document $document): void
    {
        DocumentModel::query()->whereKey($document->getId()->toString())->delete();
    }
}

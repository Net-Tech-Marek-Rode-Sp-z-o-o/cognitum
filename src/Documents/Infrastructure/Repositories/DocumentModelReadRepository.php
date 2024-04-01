<?php

declare(strict_types=1);

namespace Modules\Documents\Infrastructure\Repositories;

use Illuminate\Contracts\Translation\Translator;
use Modules\Documents\Domain\Document;
use Modules\Documents\Domain\Exceptions\DocumentNotFoundException;
use Modules\Documents\Domain\Repositories\DocumentReadRepositoryInterface;
use Modules\Documents\Domain\ValueObjects\DocumentId;
use Modules\Documents\Infrastructure\DataAccess\DocumentModel;
use Modules\Documents\Infrastructure\DataAccess\Mappers\DocumentModelMapper;

final readonly class DocumentModelReadRepository implements DocumentReadRepositoryInterface
{
    public function __construct(
        private Translator $translator,
        private DocumentModelMapper $mapper,
    ) {
    }

    public function find(DocumentId $id): Document
    {
        $model = DocumentModel::query()->whereKey($id->toString())->first();

        if ($model instanceof DocumentModel) {
            return $this->mapper->fromModelToDomain($model);
        }

        throw $this->newDocumentNotFoundException();
    }

    public function newDocumentNotFoundException(): DocumentNotFoundException
    {
        return new DocumentNotFoundException(
            message: $this->translator->get('documents::exceptions.document_not_found'),
        );
    }
}

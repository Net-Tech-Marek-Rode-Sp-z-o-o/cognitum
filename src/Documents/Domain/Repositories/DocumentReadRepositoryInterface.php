<?php

declare(strict_types=1);

namespace Modules\Documents\Domain\Repositories;

use Modules\Documents\Domain\Document;
use Modules\Documents\Domain\Exceptions\DocumentNotFoundException;
use Modules\Documents\Domain\ValueObjects\DocumentId;

interface DocumentReadRepositoryInterface
{
    /**
     * @throws DocumentNotFoundException
     */
    public function find(DocumentId $id): Document;
}

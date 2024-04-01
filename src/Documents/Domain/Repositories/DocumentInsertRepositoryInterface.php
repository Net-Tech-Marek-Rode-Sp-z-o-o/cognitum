<?php

declare(strict_types=1);

namespace Modules\Documents\Domain\Repositories;

use Modules\Documents\Domain\Document;

interface DocumentInsertRepositoryInterface
{
    public function save(Document $document): void;

    public function delete(Document $document): void;
}

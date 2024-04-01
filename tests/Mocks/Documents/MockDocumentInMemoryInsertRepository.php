<?php

declare(strict_types=1);

namespace Tests\Mocks\Documents;

use Modules\Documents\Domain\Document;
use Modules\Documents\Domain\Repositories\DocumentInsertRepositoryInterface;

final class MockDocumentInMemoryInsertRepository implements DocumentInsertRepositoryInterface
{
    /**
     * @param  Document[]  $storage
     */
    public function __construct(
        private array $storage = [],
    ) {
    }

    public function save(Document $document): void
    {
        $this->storage[$document->getId()->toString()] = $document;
    }

    public function delete(Document $document): void
    {
        unset($this->storage[$document->getId()->toString()]);
    }

    public function getDocumentById(string $id): ?Document
    {
        return $this->storage[$id] ?? null;
    }
}

<?php

declare(strict_types=1);

namespace Modules\Documents\Api;

use Modules\Documents\Api\Data\DocumentResource;

interface DocumentFacadeInterface
{
    public function getDocument(string $id): DocumentResource;

    public function deleteDocument(string $id): DocumentResource;
}

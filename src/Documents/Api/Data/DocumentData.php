<?php

declare(strict_types=1);

namespace Modules\Documents\Api\Data;

final readonly class DocumentData
{
    public function __construct(
        public string $id,
        public string $fileName,
        public string $content,
    ) {
    }
}

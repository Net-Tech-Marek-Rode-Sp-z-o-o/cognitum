<?php

declare(strict_types=1);

namespace Component\Bus\QueryBus;

use Attribute;

#[Attribute]
final class QueryHandler
{
    public function __construct(
        public string $queryHandler
    ) {
    }
}

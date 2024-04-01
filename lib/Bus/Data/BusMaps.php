<?php

declare(strict_types=1);

namespace Component\Bus\Data;

final readonly class BusMaps
{
    public function __construct(
        public array $commandsMap,
        public array $queriesMap,
    ) {
    }
}

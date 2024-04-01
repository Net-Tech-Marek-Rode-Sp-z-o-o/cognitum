<?php

declare(strict_types=1);

namespace Component\Bus\CommandBus;

use Attribute;

#[Attribute]
final class CommandHandler
{
    public function __construct(
        public string $commandHandler
    ) {
    }
}

<?php

declare(strict_types=1);

namespace Component\Bus\CommandBus;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}

<?php

declare(strict_types=1);

namespace Component\Bus\CommandBus;

use Illuminate\Bus\Dispatcher;

final readonly class CommandBus implements CommandBusInterface
{
    public function __construct(private Dispatcher $bus)
    {
    }

    public function dispatch(CommandInterface $command): void
    {
        $this->bus->dispatch($command);
    }
}

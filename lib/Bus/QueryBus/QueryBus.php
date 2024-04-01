<?php

declare(strict_types=1);

namespace Component\Bus\QueryBus;

use Illuminate\Bus\Dispatcher;

final readonly class QueryBus implements QueryBusInterface
{
    public function __construct(private Dispatcher $bus)
    {
    }

    /** {@inheritDoc} */
    public function handle(QueryInterface $query)
    {
        return $this->bus->dispatchSync($query);
    }
}

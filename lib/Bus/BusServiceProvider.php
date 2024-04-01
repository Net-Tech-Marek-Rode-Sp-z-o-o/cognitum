<?php

declare(strict_types=1);

namespace Component\Bus;

use Component\Bus\CommandBus\CommandBus;
use Component\Bus\CommandBus\CommandBusInterface;
use Component\Bus\QueryBus\QueryBus;
use Component\Bus\QueryBus\QueryBusInterface;
use Component\Bus\Services\BusMapService;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

final class BusServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->resolving(Dispatcher::class, function (Dispatcher $dispatcher): void {
            /** @var BusMapService $busMapService */
            $busMapService = $this->app->make(BusMapService::class);

            $dispatcher->map($busMapService->getCommandMaps());
            $dispatcher->map($busMapService->getQueryMaps());
        });
    }

    public function register(): void
    {
        $this->app->singleton(
            CommandBusInterface::class,
            CommandBus::class
        );

        $this->app->singleton(
            QueryBusInterface::class,
            QueryBus::class
        );
    }
}

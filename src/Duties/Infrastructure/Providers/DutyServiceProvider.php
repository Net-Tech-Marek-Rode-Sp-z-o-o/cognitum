<?php

declare(strict_types=1);

namespace Modules\Duties\Infrastructure\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Modules\Duties\Domain\Enums\DutyTypeEnum;
use Modules\Duties\Domain\Repositories\DutyInsertRepositoryInterface;
use Modules\Duties\Infrastructure\Adapters\DocumentAdapter;
use Modules\Duties\Infrastructure\Adapters\DocumentAdapterInterface;
use Modules\Duties\Infrastructure\Parsers\DTR\DTRParser;
use Modules\Duties\Infrastructure\Parsers\ParserRegistry;
use Modules\Duties\Infrastructure\Repositories\DutyModelInsertRepository;

final class DutyServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../Resources/Views', 'duties');
        $this->loadTranslationsFrom(__DIR__.'/../../Resources/Lang', 'duties');
        $this->loadJsonTranslationsFrom(__DIR__.'/../../Resources/Lang');
        $this->mergeConfigFrom(__DIR__.'/../../Resources/Config/duties.php', 'duties');
    }

    public function register(): void
    {
        $this->app->scoped(DocumentAdapterInterface::class, DocumentAdapter::class);
        $this->app->scoped(DutyInsertRepositoryInterface::class, DutyModelInsertRepository::class);

        $this->app->singleton(ParserRegistry::class, function () {
            return new ParserRegistry(
                $this->app->make('translator'),
                [
                    DutyTypeEnum::DTR->value => $this->app->get(DTRParser::class),
                ],
            );
        });
    }

    public function provides(): array
    {
        return [
            ParserRegistry::class,
            DocumentAdapterInterface::class,
            DutyInsertRepositoryInterface::class,
        ];
    }
}

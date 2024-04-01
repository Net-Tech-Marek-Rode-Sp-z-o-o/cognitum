<?php

declare(strict_types=1);

namespace Modules\Documents\Infrastructure\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Modules\Documents\Api\DocumentFacadeInterface;
use Modules\Documents\Application\Facades\DocumentFacade;
use Modules\Documents\Application\Services\DocumentStorageServiceInterface;
use Modules\Documents\Domain\Repositories\DocumentInsertRepositoryInterface;
use Modules\Documents\Domain\Repositories\DocumentReadRepositoryInterface;
use Modules\Documents\Infrastructure\DataAccess\Mappers\DocumentModelMapper;
use Modules\Documents\Infrastructure\Repositories\DocumentModelInsertRepository;
use Modules\Documents\Infrastructure\Repositories\DocumentModelReadRepository;
use Modules\Documents\Infrastructure\Services\DocumentFilesystemStorageService;

final class DocumentServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../Resources/Views', 'documents');
        $this->loadTranslationsFrom(__DIR__.'/../../Resources/Lang', 'documents');
        $this->loadJsonTranslationsFrom(__DIR__.'/../../Resources/Lang');
        $this->mergeConfigFrom(__DIR__.'/../../Resources/Config/documents.php', 'documents');
    }

    public function register(): void
    {
        $this->app->scoped(DocumentFacadeInterface::class, DocumentFacade::class);
        $this->app->scoped(DocumentInsertRepositoryInterface::class, DocumentModelInsertRepository::class);

        $this->app->scoped(DocumentStorageServiceInterface::class, fn () => new DocumentFilesystemStorageService(
            $this->app->make('translator'),
        ));

        $this->app->scoped(DocumentReadRepositoryInterface::class, fn () => new DocumentModelReadRepository(
            $this->app->make('translator'),
            $this->app->make(DocumentModelMapper::class),
        ));
    }

    public function provides(): array
    {
        return [
            DocumentFacadeInterface::class,
            DocumentInsertRepositoryInterface::class,
            DocumentReadRepositoryInterface::class,
            DocumentStorageServiceInterface::class,
        ];
    }
}

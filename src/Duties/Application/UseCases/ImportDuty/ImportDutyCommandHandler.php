<?php

declare(strict_types=1);

namespace Modules\Duties\Application\UseCases\ImportDuty;

use Modules\Duties\Domain\Duty;
use Modules\Duties\Domain\Repositories\DutyInsertRepositoryInterface;
use Modules\Duties\Infrastructure\Adapters\DocumentAdapterInterface;
use Modules\Duties\Infrastructure\Parsers\ParserRegistry;

final readonly class ImportDutyCommandHandler
{
    public function __construct(
        private ParserRegistry $parserRegistry,
        private DocumentAdapterInterface $documentAdapter,
        private DutyInsertRepositoryInterface $dutyInsertRepository,
    ) {
    }

    public function handle(ImportDutyCommand $command): void
    {
        $parser = $this->parserRegistry->get($command->type);
        $duties = $parser->handle($this->documentAdapter->readDocument($command->documentId));

        collect($duties)->each(fn (Duty $duty) => $this->dutyInsertRepository->save($duty));

        $this->documentAdapter->removeDocument($command->documentId);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\Duties\UseCases;

use Modules\Duties\Application\UseCases\ImportDuty\ImportDutyCommand;
use Modules\Duties\Application\UseCases\ImportDuty\ImportDutyCommandHandler;
use Modules\Duties\Domain\Enums\DutyTypeEnum;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\Duties\MockDocumentAdapter;
use Tests\Mocks\Duties\MockDutyInMemoryInsertRepository;
use Tests\ObjectMothers\Duties\ParserRegistryFactory;

final class ImportDutyCommandHandlerTest extends TestCase
{
    public function testImportingDuties(): void
    {
        $handler = new ImportDutyCommandHandler(
            parserRegistry: ParserRegistryFactory::new(),
            documentAdapter: new MockDocumentAdapter(),
            dutyInsertRepository: $repository = new MockDutyInMemoryInsertRepository(),
        );

        $handler->handle(new ImportDutyCommand(
            type: DutyTypeEnum::DTR,
            documentId: 'document-id',
        ));

        $this->assertNotEmpty($repository->getAll());
    }
}

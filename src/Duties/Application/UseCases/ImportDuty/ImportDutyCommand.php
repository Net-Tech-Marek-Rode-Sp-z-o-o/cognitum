<?php

declare(strict_types=1);

namespace Modules\Duties\Application\UseCases\ImportDuty;

use Component\Bus\CommandBus\CommandHandler;
use Component\Bus\CommandBus\CommandInterface;
use Modules\Duties\Domain\Enums\DutyTypeEnum;

#[CommandHandler(ImportDutyCommandHandler::class)]
final readonly class ImportDutyCommand implements CommandInterface
{
    public function __construct(
        public DutyTypeEnum $type,
        public string $documentId,
    ) {
    }
}
